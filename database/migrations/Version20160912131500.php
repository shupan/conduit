<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160912131500 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            "CREATE TABLE `tmp_spec_gv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` bigint(21) DEFAULT NULL COMMENT 'app_id',
  `account_id` bigint(21) DEFAULT NULL COMMENT 'account_id',
  `created_time` int(11) DEFAULT NULL COMMENT 'time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`app_id`,`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='中国';"

        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
