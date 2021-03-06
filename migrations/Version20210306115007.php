<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210306115007 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE short_link (id INT UNSIGNED AUTO_INCREMENT NOT NULL, owner_id INT UNSIGNED NOT NULL, original VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_566B5764989D9B62 (slug), INDEX IDX_566B57647E3C61F9 (owner_id), INDEX IDX_SLUG (slug), INDEX IDX_CREATED_AT (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT UNSIGNED AUTO_INCREMENT NOT NULL, username VARCHAR(40) NOT NULL, token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D6495F37A13B (token), INDEX IDX_USERNAME (username), INDEX IDX_TOKEN (token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE short_link ADD CONSTRAINT FK_566B57647E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE short_link DROP FOREIGN KEY FK_566B57647E3C61F9');
        $this->addSql('DROP TABLE short_link');
        $this->addSql('DROP TABLE `user`');
    }
}
