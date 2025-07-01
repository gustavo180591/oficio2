<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701034231_AddDelegacionesTable extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add delegaciones table and insert initial data';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delegaciones (
            id SERIAL PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL
        )');

        // Insert delegaciones
        $delegaciones = [
            'Centro',
            'VILLA CABELLO',
            'SANTA RITA',
            'VILLA URQUIZA',
            'ITAEMBÉ MINÍ ESTE',
            'ITAEMBÉ MINÍ OESTE',
            'LAS DOLORES NORTE',
            'LAS DOLORES SUR',
            'Miguel Lanús',
            'Chacra 32-33',
            'Itaembé Guazú'
        ];

        foreach ($delegaciones as $delegacion) {
            $this->addSql('INSERT INTO delegaciones (nombre) VALUES (:nombre)', [
                'nombre' => $delegacion
            ]);
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE delegaciones');
    }
}
