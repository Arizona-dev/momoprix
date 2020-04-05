<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200405175258 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81B171EB6C');
        $this->addSql('DROP INDEX IDX_D4E6F81B171EB6C ON address');
        $this->addSql('ALTER TABLE address ADD customer_id INT DEFAULT NULL, DROP customer_id_id, CHANGE digicode digicode VARCHAR(20) DEFAULT NULL, CHANGE floor floor VARCHAR(5) DEFAULT NULL, CHANGE elevator elevator SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F819395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('CREATE INDEX IDX_D4E6F819395C3F3 ON address (customer_id)');
        $this->addSql('ALTER TABLE category CHANGE image_url image_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE delivery CHANGE order_id_id order_id_id INT DEFAULT NULL, CHANGE address_id_id address_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` CHANGE customer_id_id customer_id_id INT DEFAULT NULL, CHANGE address_id_id address_id_id INT DEFAULT NULL, CHANGE date_payment date_payment DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE price_weight price_weight NUMERIC(5, 2) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE specifications specifications VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F819395C3F3');
        $this->addSql('DROP INDEX IDX_D4E6F819395C3F3 ON address');
        $this->addSql('ALTER TABLE address ADD customer_id_id INT DEFAULT NULL, DROP customer_id, CHANGE digicode digicode VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE floor floor VARCHAR(5) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE elevator elevator SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81B171EB6C FOREIGN KEY (customer_id_id) REFERENCES customer (id)');
        $this->addSql('CREATE INDEX IDX_D4E6F81B171EB6C ON address (customer_id_id)');
        $this->addSql('ALTER TABLE category CHANGE image_url image_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE delivery CHANGE order_id_id order_id_id INT DEFAULT NULL, CHANGE address_id_id address_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` CHANGE customer_id_id customer_id_id INT DEFAULT NULL, CHANGE address_id_id address_id_id INT DEFAULT NULL, CHANGE date_payment date_payment DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE product CHANGE price_weight price_weight NUMERIC(5, 2) DEFAULT \'NULL\', CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE specifications specifications VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
