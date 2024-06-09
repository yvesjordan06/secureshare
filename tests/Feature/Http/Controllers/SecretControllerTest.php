<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Secret;
use App\Notification\NewSecretNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SecretController
 */
final class SecretControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('secrets.create'));

        $response->assertOk();
        $response->assertViewIs('secret.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SecretController::class,
            'store',
            \App\Http\Requests\SecretStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $content = $this->faker->paragraphs(3, true);
        $delete_when_viewed = $this->faker->boolean();

        Notification::fake();

        $response = $this->post(route('secrets.store'), [
            'content' => $content,
            'delete_when_viewed' => $delete_when_viewed,
        ]);

        $secrets = Secret::query()
            ->where('content', $content)
            ->where('delete_when_viewed', $delete_when_viewed)
            ->get();
        $this->assertCount(1, $secrets);
        $secret = $secrets->first();

        $response->assertRedirect(route('secret.create'));
        $response->assertSessionHas('secret.id', $secret->id);

        Notification::assertSentTo($secret->content, NewSecretNotification::class, function ($notification) use ($secret) {
            return $notification->secret->is($secret);
        });
    }
}
