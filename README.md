# PHP-CS-Fixer

# Installation

Before you make `composer require` in your project, you must specify the path to the repository.
To do this, add the lines in the composer.json file:
```
"repositories": [
  {
    "type": "git",
    "url": "git@gitlab.fac.im:taptima/php-cs-fixer.git"
  }
]
```

After that do `composer require taptima/php-cs-fixer`.

```bash
composer require --dev taptima/php-cs-custom-fixer
```

### Configuration

```php
// .php_cs
<?php

$config = PhpCsFixer\Config::create()
    // ...
    ->registerCustomFixers(new Taptima\CS\Fixers())
    // ...
;

return $config;
```

# Fixers


## Taptima/doctrine_migrations

Remove useless getDescription(), up(), down() and comments from Doctrine\Migrations\AbstractMigration if needed.

### Configuration

```php
// .php_cs
<?php

$config = PhpCsFixer\Config::create()
    // ...
    ->setRules([
        // ...
        'Taptima/doctrine_migrations' => true,
        // ...
    ])
    // ...
    ->registerCustomFixers(new Taptima\CS\Fixers())
;

return $config;
```

**OR** using my [rule list builder](doc/rule-set-factory.md).

```php
// .php_cs.dist
<?php

$config = PhpCsFixer\Config::create()
    // ...
    ->setRules(Taptima\CS\RuleSetFactory::create()
        ->enable('Taptima/doctrine_migrations')
        ->getRules()
    ])
    // ...
    ->registerCustomFixers(new Taptima\CS\Fixers())
;

return $config;
```

### Fixes

```diff
--- Original                                                                     // 80 chars
+++ New                                                                          //
@@ @@                                                                            //
 use Doctrine\DBAL\Schema\Schema;                                                //
 use Doctrine\Migrations\AbstractMigration;                                      //
                                                                                 //
-/**                                                                             //
- * Auto-generated Migration: Please modify to your needs!                       //
- */                                                                             //
 final class Version20190323095102 extends AbstractMigration                     //
 {                                                                               //
-    public function getDescription()                                            //
-    {                                                                           //
-        return '';                                                              //
-    }                                                                           //
                                                                                 //
     public function up(Schema $schema)                                          //
     {                                                                           //
-        // this up() migration is auto-generated, please modify it to your needs//
         $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');
                                                                                 //
         $this->addSql('CREATE TABLE admin (identifier CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', PRIMARY KEY(identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
@@ @@                                                                            //
                                                                                 //
     public function down(Schema $schema)                                        //
     {                                                                           //
-        // this down() migration is auto-generated, please modify it to your needs
         $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');
                                                                                 //
         $this->addSql('DROP TABLE admin');                                      //
     }                                                                           //
 }                                                                               //
                                                                                 //
```
### Configuration

```php
// .php_cs
<?php

$config = PhpCsFixer\Config::create()
    // ...
    ->setRules([
        // ...
        'Taptima/doctrine_migrations' => [ 'instanceof' => [ 'Doctrine\Migrations\AbstractMigration' ] ],
        // ...
    ])
    // ...
    ->registerCustomFixers(new Taptima\CS\Fixers())
;

return $config;
```

**OR** using my [rule list builder](doc/rule-set-factory.md).

```php
// .php_cs.dist
<?php

$config = PhpCsFixer\Config::create()
    // ...
    ->setRules(Taptima\CS\RuleSetFactory::create()
        ->enable('Taptima/doctrine_migrations', [ 'instanceof' => [ 'Doctrine\Migrations\AbstractMigration' ] ])
        ->getRules()
    ])
    // ...
    ->registerCustomFixers(new Taptima\CS\Fixers())
;

return $config;
```

### Fixes

```diff
--- Original                                                                     // 80 chars
+++ New                                                                          //
@@ @@                                                                            //
 use Doctrine\DBAL\Schema\Schema;                                                //
 use Doctrine\Migrations\AbstractMigration;                                      //
                                                                                 //
-/**                                                                             //
- * Auto-generated Migration: Please modify to your needs!                       //
- */                                                                             //
 final class Version20190323095102 extends AbstractMigration                     //
 {                                                                               //
-    public function getDescription()                                            //
-    {                                                                           //
-        return '';                                                              //
-    }                                                                           //
                                                                                 //
     public function up(Schema $schema)                                          //
     {                                                                           //
-        // this up() migration is auto-generated, please modify it to your needs//
         $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');
                                                                                 //
         $this->addSql('CREATE TABLE admin (identifier CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', PRIMARY KEY(identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
@@ @@                                                                            //
                                                                                 //
     public function down(Schema $schema)                                        //
     {                                                                           //
-        // this down() migration is auto-generated, please modify it to your needs
         $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');
                                                                                 //
         $this->addSql('DROP TABLE admin');                                      //
     }                                                                           //
 }                                                                               //
                                                                                 //
```

## Taptima/ordered_setters_and_getters

Class/interface/trait setters and getters MUST BE ordered (order is setter, isser, hasser, adder, remover, getter).

### Configuration

```php
// .php_cs
<?php

$config = PhpCsFixer\Config::create()
    // ...
    ->setRules([
        // ...
        'Taptima/ordered_setters_and_getters' => true,
        // ...
    ])
    // ...
    ->registerCustomFixers(new Taptima\CS\Fixers())
;

return $config;
```

**OR** using my [rule list builder](doc/rule-set-factory.md).

```php
// .php_cs.dist
<?php

$config = PhpCsFixer\Config::create()
    // ...
    ->setRules(Taptima\CS\RuleSetFactory::create()
        ->enable('Taptima/ordered_setters_and_getters')
        ->getRules()
    ])
    // ...
    ->registerCustomFixers(new Taptima\CS\Fixers())
;

return $config;
```

### Fixes

```diff
--- Original                                                                     // 80 chars
+++ New                                                                          //
@@ @@                                                                            //
         $this->firstName = $firstName;                                          //
     }                                                                           //
                                                                                 //
-    public function setName($name)                                              //
+    public function getFirstName()                                              //
     {                                                                           //
-        $this->name = $name;                                                    //
+        return $this->firstName;                                                //
     }                                                                           //
                                                                                 //
-    public function isEnabled()                                                 //
+    public function setName($name)                                              //
     {                                                                           //
-        return $this->enabled;                                                  //
+        $this->name = $name;                                                    //
     }                                                                           //
                                                                                 //
     public function getName()                                                   //
@@ @@                                                                            //
         return $this->name;                                                     //
     }                                                                           //
                                                                                 //
-    public function getIdentifier()                                             //
+    public function isEnabled()                                                 //
     {                                                                           //
-        return $this->identifier;                                               //
+        return $this->enabled;                                                  //
     }                                                                           //
                                                                                 //
-    public function getFirstName()                                              //
+    public function getIdentifier()                                             //
     {                                                                           //
-        return $this->firstName;                                                //
+        return $this->identifier;                                               //
     }                                                                           //
                                                                                 //
     public function enable()                                                    //
@@ @@                                                                            //
     }                                                                           //
                                                                                 //
     /**                                                                         //
-     * @return Item                                                             //
-     */                                                                         //
-    public function getItems()                                                  //
-    {                                                                           //
-        return $this->items;                                                    //
-    }                                                                           //
-                                                                                //
-    /**                                                                         //
      * @param Item $item                                                        //
      * @return User                                                             //
      */                                                                         //
@@ @@                                                                            //
         $this->items->removeElement($item);                                     //
                                                                                 //
         return $this;                                                           //
+    }                                                                           //
+                                                                                //
+    /**                                                                         //
+     * @return Item                                                             //
+     */                                                                         //
+    public function getItems()                                                  //
+    {                                                                           //
+        return $this->items;                                                    //
     }                                                                           //
 }                                                                               //
                                                                                 //
```

# Contributions

Before to create a pull request to submit your contributon, you must:
 - run tests and be sure nothing is broken
 - rebuilt the documentation

## How to run tests

```bash
composer tests
```

## How to rebuild the documentation

```bash
tools/doc > README.md
```
