<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\KategoriKeperluan;
use App\Models\Tamu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GuestbookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed necessary categories for tests
        KategoriKeperluan::create(['nama_kategori' => 'Konsultasi Program Belajar']);
        KategoriKeperluan::create(['nama_kategori' => 'Pendaftaran Siswa Baru']);

        // Seed default admin
        Admin::create([
            'name' => 'Admin Meteor',
            'username' => 'admin',
            'email' => 'admin@meteor.com',
            'password' => Hash::make('password123'),
        ]);
    }

    /**
     * Test guest form renders.
     */
    public function test_guest_form_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Buku Tamu Digital');
        $response->assertSee('Bimbingan Belajar Meteor');
    }

    /**
     * Test form validation constraints.
     */
    public function test_guest_form_validation_prevents_invalid_submission(): void
    {
        $response = $this->post('/', [
            'nama' => '',
            'nomor_hp' => 'abc', // non-numeric
            'alamat' => '',
            'kategori_id' => 99, // non-existent
        ]);

        $response->assertSessionHasErrors(['nama', 'nomor_hp', 'alamat', 'kategori_id']);
        $this->assertEquals(0, Tamu::count());
    }

    /**
     * Test successful guest form submission.
     */
    public function test_guest_form_submission_stores_data(): void
    {
        $category = KategoriKeperluan::first();

        $response = $this->post('/', [
            'nama' => 'Chusnul Bariya',
            'nomor_hp' => '08123456789',
            'alamat' => 'Jl. Raya Meteor No. 12',
            'kategori_id' => $category->id,
        ]);

        $response->assertRedirect(route('tamu.sukses'));
        $response->assertSessionHas('nama_tamu', 'Chusnul Bariya');
        
        $this->assertDatabaseHas('tamus', [
            'nama' => 'Chusnul Bariya',
            'nomor_hp' => '08123456789',
            'alamat' => 'Jl. Raya Meteor No. 12',
            'kategori_id' => $category->id,
        ]);
    }

    /**
     * Test admin login page renders.
     */
    public function test_admin_login_renders_successfully(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertSee('Admin Login');
    }

    /**
     * Test admin login validation fails.
     */
    public function test_admin_login_fails_with_invalid_credentials(): void
    {
        $response = $this->post('/admin/login', [
            'username' => 'admin',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors(['username']);
        $this->assertFalse(auth()->check());
    }

    /**
     * Test admin login succeeds.
     */
    public function test_admin_login_succeeds_with_valid_credentials(): void
    {
        $response = $this->post('/admin/login', [
            'username' => 'admin',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertTrue(auth()->check());
        $this->assertEquals('Admin Meteor', auth()->user()->name);
    }

    /**
     * Test unauthenticated access is redirected.
     */
    public function test_unauthenticated_access_is_blocked(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Test authenticated admin can see dashboard.
     */
    public function test_authenticated_admin_can_access_dashboard(): void
    {
        $admin = Admin::first();
        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Ringkasan Statistik');
        $response->assertSee('QR Code Buku Tamu');
    }
}
