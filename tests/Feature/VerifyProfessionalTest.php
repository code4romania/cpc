<?php

use App\Actions\VerifyProfessional;
use App\Models\User;
use App\Notifications\ProfessionalVerified;
use Illuminate\Support\Facades\Notification;

test('verify professional sets verified_at and sends notification', function () {
    Notification::fake();

    $user = User::factory()->unverifiedProfessional()->create();

    $verified = app(VerifyProfessional::class)($user);

    expect($verified->verified_at)->not->toBeNull()
        ->and($verified->isVerifiedProfessional())->toBeTrue();

    Notification::assertSentTo($user, ProfessionalVerified::class);
});

test('verify professional is idempotent when already verified', function () {
    Notification::fake();

    $user = User::factory()->verifiedProfessional()->create();
    $original = $user->verified_at;

    $verified = app(VerifyProfessional::class)($user);

    expect($verified->verified_at->equalTo($original))->toBeTrue();
    Notification::assertNothingSent();
});
