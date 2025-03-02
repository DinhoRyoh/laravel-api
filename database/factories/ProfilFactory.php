<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use App\Models\Profil;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profil>
 */
class ProfilFactory extends Factory
{
    protected $model = Profil::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Génération d'un nom de fichier unique
        $fileName = 'images/' . $this->faker->uuid() . '.jpg';

        // Télécharger une image aléatoire et l'enregistrer dans storage
        $image = file_get_contents('https://picsum.photos/400/400'); 
        Storage::disk('public')->put($fileName, $image);

        return [
            'lastname' => fake()->name(),
            'firstname' => fake()->name(),
            'status' => $this->faker->randomElement(['inactif', 'en attente', 'actif']),
            'image' => 'storage/' . $fileName,
            'user_id' => User::find(1)->id
        ];
    }
}
