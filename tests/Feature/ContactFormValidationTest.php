<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use App\Models\User;
use App\Notifications\InquiryEmailNotification;
use App\Notifications\UserEmailNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Support\Str;

class ContactFormValidationTest extends TestCase
{
    protected $user;
    protected $inquiry;

    /**
     * This method is called before each test.
     * 
     * @return void
     */
    protected function setUp(): void
    {
        # Call parent setUp function
        parent::setUp();

        # Make notifications fake to prevent sending real notifications
        Notification::fake();

        # Create fake user
        $this->user = User::factory()->create();
    }

    /**
     * Test contact form submit
     * 
     * @return void
     */
    public function test_contact_form()
    {   
        # Check if user can open contact page
        $response = $this->actingAs($this->user)->get('/contact');

        # Check if status is 200
        $response->assertStatus(200);
        
        # Check response with empty data for contact form
        $response = $this->sendInquiry('', '', '', '')->assertSessionHasErrors();
        
        # Check name errors
        $response = $this->sendInquiry(Str::random(51), 'johndoe@mail.com', '+359-888999888', Str::random(500))->assertSessionHasErrors(['name']);
        
        # Check email errors
        $response = $this->sendInquiry(Str::random(50), 'johndoe@mail.com1', '+359 88 8999888', Str::random(500))->assertSessionHasErrors(['email']);
        
        # Check phone errors
        $response = $this->sendInquiry(Str::random(50), 'johndoe@mail.com', '+359-888999(888)-', Str::random(500))->assertSessionHasErrors(['phone']);
        $response = $this->sendInquiry(Str::random(50), 'johndoe@mail.com', '+359-888999(888)(', Str::random(500))->assertSessionHasErrors(['phone']);
        $response = $this->sendInquiry(Str::random(50), 'johndoe@mail.com', '+359-888999(888)(', Str::random(500))->assertSessionHasErrors(['phone']);
        
        # Check message errors
        $response = $this->sendInquiry(Str::random(50), 'johndoe@mail.com', '+359 88 8999888', Str::random(501))->assertSessionHasErrors(['message']);

        # Pass valid data
        $response = $this->sendInquiry('John Doe', 'toni@eurocoders.com', '+359888999888', Str::random(500))->assertSessionHasNoErrors();

        # Get created inquiry
        $this->inquiry = Inquiry::whereId($response->json('data')['id']);

        # Check if user email is sent
        Notification::assertSentTo($this->user, UserEmailNotification::class);

        # Check if inquiry email is sent
        Notification::assertSentTo($this->inquiry->get(), InquiryEmailNotification::class);
    }

    /**
     * This method is called after each test
     * 
     * @return void 
     */
    protected function tearDown(): void
    {
        # Call parent tearDown function
        parent::tearDown();

        # Delete fake user
        $this->user->delete();

        # Delete inquiry
        $this->inquiry->delete();
    }
    
    private function sendInquiry($name, $email, $phone, $message)
    {
        return $this->post('/contact', [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message'=> $message
        ]);
    }
}
