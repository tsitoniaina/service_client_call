<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240711110142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create user sequence and check existence of user table';
    }

    public function up(Schema $schema): void
    {
        // Check if the sequence exists, if not, create it
        $this->addSql('DO $$
        BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_class WHERE relname = \'user_id_seq\') THEN
                CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;
            END IF;
        END$$;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE IF EXISTS "user_id_seq" CASCADE');
    }
}
