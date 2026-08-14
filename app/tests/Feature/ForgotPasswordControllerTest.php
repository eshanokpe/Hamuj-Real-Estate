<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    public function test_send_reset_link_email_alias_method_exists(): void
    {
        $controller = new \App\Http\Controllers\Auth\ForgotPasswordController();
        $request = new Request([
            'email' => 'missing-user@example.com',
        ]);

        $response = $controller->sendResetLinkEmail($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(true, json_decode($response->getContent(), true)['success']);
    }
}
