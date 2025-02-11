
# Invoice Parser

Ce projet est une application Symfony qui permet de parser des fichiers de type JSON et CSV contenant des informations sur des factures. Les données extraites sont ensuite mises à jour dans la base de données via des requêtes SQL.

## Prérequis

- Docker
- Docker Compose

## Installation

1. Clone le projet dans ton répertoire local.

   ```bash
   git clone https://github.com/ton-repository/invoice-parser.git
   cd invoice-parser
   ```

2. Construis et lance les containers Docker.

   ```bash
   docker-compose up --build -d 
   ```

   Cela créera les containers pour l'application Symfony et la base de données PostgreSQL.

3. Installe les dépendances PHP via Composer.

   ```bash
   docker-compose exec app composer install
   ```

4. Créer la base de données et exécute les migrations.

   ```bash
   docker-compose exec app php bin/console doctrine:migrations:migrate
   ```

## Lancer l'application

### 1. Exécuter la commande de parsing

Pour parser les fichiers de factures (`json` ou `csv`), exécute la commande suivante :

   ```bash
  docker-compose run --rm app php bin/console app:parse
   ```

Cette commande va charger et parser les fichiers, puis mettre à jour les enregistrements dans la base de données.

### 2. Lancer les tests unitaires

Pour vérifier le bon fonctionnement de l'application, tu peux exécuter les tests unitaires via PHPUnit. Pour cela, utilise la commande suivante :

   ```bash
  docker-compose exec app php vendor/bin/phpunit tests/InvoiceParserTest.php
   ```

Pour exécuter tous les tests dans le projet, tu peux utiliser :

   ```bash
  docker-compose exec app php vendor/bin/phpunit
   ```
---


#Boureima 

Bien sûr ! Voici une note claire et professionnelle à ajouter dans ton fichier **README.md** pour expliquer les améliorations de ton `InvoiceParser` :  

---

#  Invoice Parser - Version améliorée 

## ✨ **Améliorations et refonte du système de parsing**  
 **Architecture modulaire et évolutive** grâce au **pattern Strategy**.  
 **Sécurisation des requêtes SQL** avec des **paramètres préparés** pour éviter les injections SQL.  
 **Support facile de nouveaux formats** (exemple : XML, Excel) sans modifier `InvoiceParser`.  

### ** Structure du code**
```
src/
 ├── Service/
 │    ├── InvoiceParser.php         # Sélectionne dynamiquement le parser selon le fichier
 │    ├── Parser/
 │    │    ├── ParserInterface.php  # Interface commune pour tous les parsers
 │    │    ├── JsonParser.php       # Gère les fichiers JSON
 │    │    ├── CsvParser.php        # Gère les fichiers CSV
 │    │    ├── XmlParser.php        # (Futur) Gestion des fichiers XML
 │    │    ├── ExcelParser.php      # (Futur) Gestion des fichiers Excel
```

##  **Comment utiliser Invoice Parser**
 **Lancer les containers Docker**  
```sh
docker-compose up --build -d
```

2️ **Exécuter la commande de parsing**  
```sh
docker-compose run --rm app php bin/console app:parse <chemin_du_fichier>
```
> Exemple :  
```sh
docker-compose run --rm app php bin/console app:parse data/invoices.json
```

3️ **Exécuter les tests unitaires**  
```sh
docker-compose exec app php vendor/bin/phpunit
```

##  **Ajout d'un nouveau format de fichier**
1. Créer un fichier `MonFormatParser.php` dans `src/Service/Parser/`
2. Implémenter `ParserInterface`
3. Ajouter la classe dans **Symfony** via `services.yaml`  

Exemple pour **XML** :  
```php
class XmlParser implements ParserInterface {
    public function parse(string $filePath): array {
        // Implémentation du parsing XML ici
    }
}
```

##  **Prochaines améliorations**
-  Ajout du support pour **XML et Excel**
-  Logs détaillés pour suivre le parsing
-  Gestion avancée des erreurs et des fichiers mal 
-   Immplementation des test