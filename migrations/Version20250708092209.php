<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250708092209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_category_skill (skill_id INT NOT NULL, category_skill_id INT NOT NULL, INDEX IDX_7437C8945585C142 (skill_id), INDEX IDX_7437C894E2FF4539 (category_skill_id), PRIMARY KEY(skill_id, category_skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skill_category_skill ADD CONSTRAINT FK_7437C8945585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_category_skill ADD CONSTRAINT FK_7437C894E2FF4539 FOREIGN KEY (category_skill_id) REFERENCES category_skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_category_skill DROP FOREIGN KEY FK_7437C8945585C142');
        $this->addSql('ALTER TABLE skill_category_skill DROP FOREIGN KEY FK_7437C894E2FF4539');
        $this->addSql('DROP TABLE category_skill');
        $this->addSql('DROP TABLE skill_category_skill');
    }
}
