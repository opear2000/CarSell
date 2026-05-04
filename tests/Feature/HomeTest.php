<?php

test('It should display No hay carros publicados.', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
        ->assertSee('No hay carros publicados.');
});
