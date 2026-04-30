<?php

test('Returns success on login page', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
});

test('Returns success on signup page', function () {
    $response = $this->get(route('signup'));

    $response->assertStatus(200);
});

test('Returns success on password reset page', function () {
    $response = $this->get(route('password.request'));

    $response->assertStatus(200);
});
