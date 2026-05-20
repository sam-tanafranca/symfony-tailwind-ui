<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260520032629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Check if the user table already exists, if not, create it
        if (!$schema->hasTable('user')) {
            $this->addSql('CREATE TABLE `user` (
                id INT AUTO_INCREMENT NOT NULL, 
                old_sys_id VARCHAR(255) DEFAULT NULL, 
                username VARCHAR(180) NOT NULL, 
                roles JSON NOT NULL, 
                roles_allowed JSON NOT NULL, 
                types JSON NOT NULL, 
                password VARCHAR(255) NOT NULL, 
                first_name VARCHAR(255) NOT NULL, 
                last_name VARCHAR(255) NOT NULL, 
                full_name VARCHAR(255) NOT NULL, 
                email VARCHAR(255) NOT NULL, 
                is_active TINYINT(1) NOT NULL, 
                is_access_all_company TINYINT(1) NOT NULL, 
                is_access_all_branch TINYINT(1) NOT NULL, 
                is_access_all_b_u TINYINT(1) NOT NULL, 
                is_access_all_division TINYINT(1) NOT NULL, 
                is_access_all_dept TINYINT(1) NOT NULL, 
                is_access_all_dept_unit TINYINT(1) NOT NULL, 
                is_access_all_emp_type TINYINT(1) NOT NULL, 
                UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), 
                UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        } else {
            $this->addSql('ALTER TABLE `user` CHANGE old_sys_id old_sys_id VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE roles_allowed roles_allowed JSON NOT NULL, CHANGE types types JSON NOT NULL');
        }
        
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `user`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
    }
}
