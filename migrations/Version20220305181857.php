<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220305181857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assigned (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, employee_id INT NOT NULL, time_production INT NOT NULL, published_at DATETIME NOT NULL, INDEX IDX_B9ACC9A166D1F9C (project_id), INDEX IDX_B9ACC9A8C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, job_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, cost INT NOT NULL, started_job DATETIME NOT NULL, INDEX IDX_5D9F75A1BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price INT NOT NULL, create_at DATETIME NOT NULL, delivery DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assigned ADD CONSTRAINT FK_B9ACC9A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assigned ADD CONSTRAINT FK_B9ACC9A8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assigned DROP FOREIGN KEY FK_B9ACC9A8C03F15C');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1BE04EA9');
        $this->addSql('ALTER TABLE assigned DROP FOREIGN KEY FK_B9ACC9A166D1F9C');
        $this->addSql('DROP TABLE assigned');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE project');
    }
}
