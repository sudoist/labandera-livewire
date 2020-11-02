<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    private $email = 'johncosio@email.com';
    private $password = 'nodepasswordtesting';

    /** @test */
    public function a_logged_in_admin_can_see_order_stats()
    {
        $this->log_in_as_admin();

        Livewire::test('dashboard.index')
            ->assertSee('Stats')
            ->assertSee('Washing in progress')
            ->assertSee('Ready for Pickup/Delivery')
            ->assertSee('Order Complete');
    }

    private function log_in_as_admin()
    {
        Livewire::test('auth.login')
            ->set('email', $this->email)
            ->set('password', $this->password)
            ->call('authenticate');

        $user = User::where('email', $this->email)->first();
        $this->assertAuthenticatedAs($user);

        $this->be($user);
    }

    /** @test */
    public function a_logged_in_admin_can_see_order_list()
    {
        $this->log_in_as_admin();

        Livewire::test('dashboard.index')
            ->assertSee('Orders')
            ->assertSee('Paid')
            ->assertSee('Order Complete');
    }
}
