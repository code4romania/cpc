<?php

test('support lines appear on the home, about, and contact pages', function () {
    $home = $this->get('/ro')->assertSuccessful()->getContent();
    $about = $this->get('/ro/about')->assertSuccessful()->getContent();
    $contact = $this->get('/ro/contact')->assertSuccessful()->getContent();

    foreach ([$home, $about, $contact] as $html) {
        expect($html)
            ->toContain('Linii de sprijin')
            ->toContain('data-support-lines')
            ->toContain('0800 800 678')
            ->toContain('116 111')
            ->toContain('Telefonul Copilului');
    }

    expect(strpos($home, 'Linii de sprijin'))->toBeLessThan(strpos($home, __('home.featured_title', [], 'ro')))
        ->and(strpos($about, __('about.notice_title', [], 'ro')))->toBeLessThan(strpos($about, 'Linii de sprijin'))
        ->and(strpos($contact, 'Linii de sprijin'))->toBeLessThan(strpos($contact, __('contact.organizations.anitp.name', [], 'ro')));
});
