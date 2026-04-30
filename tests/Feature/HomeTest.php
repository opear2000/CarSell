<?php

test('It should display there are no published cars!', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
        ->assertSee('There are no published cars.');
});
