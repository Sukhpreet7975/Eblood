<?php

test('admin home and dashboard routes resolve to distinct paths', function () {
    $homePath = parse_url(route('admin.home'), PHP_URL_PATH);
    $dashboardPath = parse_url(route('admin.dashboard'), PHP_URL_PATH);

    expect($homePath)->toBe('/admin/home');
    expect($dashboardPath)->toBe('/admin/dashboard');
    expect($homePath)->not->toBe($dashboardPath);
});
