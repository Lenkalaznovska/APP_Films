# Filmový Management Systém

Vítejte v repozitáři webových stránek Filmového Management Systému. Tento projekt je jednoduchá webová aplikace pro správu databáze filmů, která umožňuje přidávání, vyhledávání a aktualizaci záznamů o filmech.

## Obsah

1. [Popis](#popis)
2. [Použité technologie](#použité-technologie)
3. [Struktura projektu](#struktura-projektu)
4. [API](#api)

## Popis

Filmový Management Systém je webová aplikace určená k efektivní správě filmů v databázi. Na této webové stránce najdete:

- **Formulář pro zadání informací o filmu:** Uživatelé mohou přidávat nové filmy do databáze zadáním názvu filmu a autora.
- **Vyhledávání filmů:** Uživatelé mohou vyhledávat filmy podle názvu a autora.
- **Zobrazení všech filmů:** Uživatelé mohou zobrazit seznam všech filmů v databázi.
- **Aktualizace filmů:** Pokud film již existuje, uživatelé mohou aktualizovat jméno autora pro existující film.
- **Živý chat:** Implementace chatu pomocí API Tawk.to pro komunikaci s uživateli.

## Použité technologie

### Frontend

- **HTML5:** Struktura webové stránky.
- **CSS3:** Stylování webové stránky.

### Backend

- **PHP:** Zpracování dat a interakce s databází.
- **MySQL:** Databáze pro ukládání informací o filmech.

### Vývojové nástroje

- **XAMPP:** Lokální webový server obsahující Apache, MySQL a PHP.
- **Apache Server:** Webový server pro provoz PHP aplikací.

## Struktura projektu

- **favicon/favicon.png:** Ikony používané na webu.

- `index.php`: Hlavní stránka s obsahem a funkcemi.
- `conn.php`: Připojení k MySQL databázi.
- `css/style.css`: Stylování stránky.
- `favicon/`: Ikony používané na webu.

## API

Projekt obsahuje následující API:

- **Tawk.to chat:** API pro integraci živého chatu Tawk.to pro komunikaci s uživateli v reálném čase.
