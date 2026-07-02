# Requirements Document

## Introduction

Dit document beschrijft de requirements voor een klantenbeheer systeem (CRUD) voor een kapsalon/behandeling bedrijf. Het systeem wordt gebouwd in Laravel 13 met Breeze authenticatie en maakt gebruik van een MySQL database (Examen-Dag1). Een Medewerker kan via dit systeem klanten aanmaken, bekijken, bijwerken en verwijderen. Het systeem richt zich uitsluitend op het beheer van klantgegevens; andere functionaliteiten zoals behandelingen en producten worden door andere teamleden ontwikkeld.

## Glossary

- **Klantenbeheer_Systeem**: Het Laravel-gebaseerde systeem voor het beheren van klantgegevens
- **Medewerker**: Een geauthenticeerde gebruiker die toegang heeft tot het klantenbeheer systeem
- **Klant**: Een persoon die geregistreerd is in het systeem met persoonlijke gegevens
- **Klantenoverzicht**: Een lijst met alle geregistreerde klanten in het systeem
- **Verplichte_Velden**: Voornaam, achternaam, telefoonnummer en email van een klant
- **Klantgegevens**: Alle informatie over een klant inclusief voornaam, achternaam, telefoonnummer, email, geboortedatum, adres, postcode, woonplaats, allergieën en wensen

## Requirements

### Requirement 1: Nieuwe Klant Aanmaken

**User Story:** Als een Medewerker wil ik een nieuwe klant kunnen toevoegen zodat ik nieuwe klanten kan registreren in het systeem.

#### Acceptance Criteria

1. WHEN een Medewerker alle Verplichte_Velden invult en op "Opslaan" klikt, THEN THE Klantenbeheer_Systeem SHALL de nieuwe Klant opslaan in de database
2. WHEN een Medewerker alle Verplichte_Velden invult en op "Opslaan" klikt, THEN THE Klantenbeheer_Systeem SHALL de nieuwe Klant tonen in het Klantenoverzicht
3. WHEN een Medewerker optionele velden zoals geboortedatum, adres, postcode of woonplaats invult, THEN THE Klantenbeheer_Systeem SHALL deze gegevens opslaan bij de Klant
4. WHEN een Medewerker op "Nieuwe klant" klikt, THEN THE Klantenbeheer_Systeem SHALL een formulier tonen met velden voor voornaam, achternaam, telefoonnummer, email, geboortedatum, adres, postcode en woonplaats
5. THE Klantenbeheer_Systeem SHALL aanmaaktijdstip en bijwerktijdstip automatisch registreren bij het aanmaken van een Klant

### Requirement 2: Validatie bij Klant Aanmaken

**User Story:** Als een Medewerker wil ik duidelijke foutmeldingen ontvangen wanneer ik ongeldige gegevens invoer zodat ik weet welke gegevens gecorrigeerd moeten worden.

#### Acceptance Criteria

1. IF een Medewerker een of meer Verplichte_Velden leeg laat en op "Opslaan" klikt, THEN THE Klantenbeheer_Systeem SHALL de melding "Vul alle verplichte velden in" tonen
2. IF een Medewerker een of meer Verplichte_Velden leeg laat en op "Opslaan" klikt, THEN THE Klantenbeheer_Systeem SHALL de Klant niet opslaan in de database
3. IF een Medewerker een ongeldig email formaat invoert, THEN THE Klantenbeheer_Systeem SHALL een foutmelding tonen dat het email adres ongeldig is
4. IF een Medewerker een ongeldig email formaat invoert, THEN THE Klantenbeheer_Systeem SHALL de Klant niet opslaan in de database
5. IF een Medewerker een ongeldig telefoonnummer formaat invoert, THEN THE Klantenbeheer_Systeem SHALL een foutmelding tonen dat het telefoonnummer ongeldig is
6. IF een Medewerker een ongeldig telefoonnummer formaat invoert, THEN THE Klantenbeheer_Systeem SHALL de Klant niet opslaan in de database

### Requirement 3: Klantenoverzicht Weergeven

**User Story:** Als een Medewerker wil ik het klantenoverzicht kunnen bekijken zodat ik klanten kan opzoeken en selecteren.

#### Acceptance Criteria

1. WHEN een Medewerker op "Klantenoverzicht" klikt, THEN THE Klantenbeheer_Systeem SHALL alle geregistreerde Klanten tonen in een lijst
2. WHEN een Medewerker op "Klantenoverzicht" klikt, THEN THE Klantenbeheer_Systeem SHALL voor elke Klant minimaal de voornaam, achternaam en email tonen
3. WHEN een Medewerker een Klant selecteert in het Klantenoverzicht, THEN THE Klantenbeheer_Systeem SHALL alle Klantgegevens van die Klant tonen
4. WHEN een Medewerker op "Klantenoverzicht" klikt, THEN THE Klantenbeheer_Systeem SHALL een knop "Nieuwe klant" tonen om een nieuwe Klant aan te maken

### Requirement 4: Lege Klantenoverzicht

**User Story:** Als een Medewerker wil ik een duidelijke melding zien wanneer er geen klanten zijn zodat ik weet dat het systeem correct werkt maar simpelweg geen data bevat.

#### Acceptance Criteria

1. WHEN een Medewerker het Klantenoverzicht opent en er zijn geen Klanten geregistreerd, THEN THE Klantenbeheer_Systeem SHALL de melding "Er zijn nog geen klanten geregistreerd" tonen
2. WHEN een Medewerker het Klantenoverzicht opent en er zijn geen Klanten geregistreerd, THEN THE Klantenbeheer_Systeem SHALL geen klantenlijst weergeven
3. WHEN een Medewerker het Klantenoverzicht opent en er zijn geen Klanten geregistreerd, THEN THE Klantenbeheer_Systeem SHALL de knop "Nieuwe klant" tonen

### Requirement 5: Klantgegevens Bijwerken

**User Story:** Als een Medewerker wil ik klantgegevens kunnen aanpassen zodat de klantgegevens actueel blijven.

#### Acceptance Criteria

1. WHEN een Medewerker een Klant heeft geselecteerd en op een bewerkingsknop klikt, THEN THE Klantenbeheer_Systeem SHALL een formulier tonen met de huidige Klantgegevens
2. WHEN een Medewerker Klantgegevens wijzigt en op "Opslaan" klikt, THEN THE Klantenbeheer_Systeem SHALL de gewijzigde gegevens opslaan in de database
3. WHEN een Medewerker Klantgegevens wijzigt en op "Opslaan" klikt, THEN THE Klantenbeheer_Systeem SHALL de bijgewerkte gegevens tonen bij de Klant
4. WHEN een Medewerker Klantgegevens wijzigt en op "Opslaan" klikt, THEN THE Klantenbeheer_Systeem SHALL het bijwerktijdstip automatisch actualiseren
5. THE Klantenbeheer_Systeem SHALL alle velden van een Klant bewerkbaar maken inclusief voornaam, achternaam, telefoonnummer, email, geboortedatum, adres, postcode en woonplaats

### Requirement 6: Validatie bij Klantgegevens Bijwerken

**User Story:** Als een Medewerker wil ik voorkomen dat ik ongeldige gegevens kan opslaan tijdens het bijwerken zodat de data-integriteit gewaarborgd blijft.

#### Acceptance Criteria

1. IF een Medewerker een ongeldig email adres invoert tijdens het bijwerken en op "Opslaan" klikt, THEN THE Klantenbeheer_Systeem SHALL een melding tonen dat de ingevoerde gegevens ongeldig zijn
2. IF een Medewerker een ongeldig email adres invoert tijdens het bijwerken en op "Opslaan" klikt, THEN THE Klantenbeheer_Systeem SHALL de wijzigingen niet opslaan
3. IF een Medewerker een ongeldig telefoonnummer invoert tijdens het bijwerken en op "Opslaan" klikt, THEN THE Klantenbeheer_Systeem SHALL een melding tonen dat de ingevoerde gegevens ongeldig zijn
4. IF een Medewerker een ongeldig telefoonnummer invoert tijdens het bijwerken en op "Opslaan" klikt, THEN THE Klantenbeheer_Systeem SHALL de wijzigingen niet opslaan
5. IF een Medewerker een Verplicht_Veld leeg maakt tijdens het bijwerken en op "Opslaan" klikt, THEN THE Klantenbeheer_Systeem SHALL een melding tonen dat alle verplichte velden ingevuld moeten zijn
6. IF een Medewerker een Verplicht_Veld leeg maakt tijdens het bijwerken en op "Opslaan" klikt, THEN THE Klantenbeheer_Systeem SHALL de wijzigingen niet opslaan

### Requirement 7: Klant Verwijderen

**User Story:** Als een Medewerker wil ik een klant kunnen verwijderen zodat verouderde klantgegevens uit het systeem verdwijnen.

#### Acceptance Criteria

1. WHEN een Medewerker een Klant heeft geselecteerd en op "Verwijderen" klikt, THEN THE Klantenbeheer_Systeem SHALL een bevestigingsdialoog tonen
2. WHEN een Medewerker het verwijderen bevestigt, THEN THE Klantenbeheer_Systeem SHALL de Klant verwijderen uit de database
3. WHEN een Medewerker het verwijderen bevestigt, THEN THE Klantenbeheer_Systeem SHALL de Klant niet meer tonen in het Klantenoverzicht
4. WHEN een Medewerker het verwijderen annuleert, THEN THE Klantenbeheer_Systeem SHALL de Klant behouden in de database
5. WHEN een Medewerker het verwijderen annuleert, THEN THE Klantenbeheer_Systeem SHALL de Medewerker terugbrengen naar het vorige scherm

### Requirement 8: Foutafhandeling bij Verwijderen

**User Story:** Als een Medewerker wil ik een duidelijke melding ontvangen wanneer een klant niet verwijderd kan worden zodat ik begrijp wat er is gebeurd.

#### Acceptance Criteria

1. IF een Medewerker een Klant probeert te verwijderen die niet meer bestaat in de database, THEN THE Klantenbeheer_Systeem SHALL de melding "Klant niet gevonden" tonen
2. IF een Medewerker een Klant probeert te verwijderen die niet meer bestaat in de database, THEN THE Klantenbeheer_Systeem SHALL geen wijzigingen aanbrengen in de database
3. IF een Medewerker een Klant probeert te verwijderen die niet meer bestaat in de database, THEN THE Klantenbeheer_Systeem SHALL de Medewerker terugbrengen naar het Klantenoverzicht

### Requirement 9: Authenticatie en Autorisatie

**User Story:** Als een systeem eigenaar wil ik dat alleen geauthenticeerde Medewerkers toegang hebben tot het klantenbeheer systeem zodat klantgegevens beschermd zijn.

#### Acceptance Criteria

1. THE Klantenbeheer_Systeem SHALL alleen toegang verlenen tot Medewerkers die zijn ingelogd via het Breeze authenticatie systeem
2. WHEN een niet-ingelogde gebruiker probeert toegang te krijgen tot het Klantenoverzicht, THEN THE Klantenbeheer_Systeem SHALL de gebruiker doorverwijzen naar de inlogpagina
3. WHEN een niet-ingelogde gebruiker probeert toegang te krijgen tot klant aanmaken, bijwerken of verwijderen functionaliteit, THEN THE Klantenbeheer_Systeem SHALL de gebruiker doorverwijzen naar de inlogpagina

### Requirement 10: Database Structuur

**User Story:** Als een ontwikkelaar wil ik dat het systeem een correcte database structuur gebruikt zodat klantgegevens consistent opgeslagen worden.

#### Acceptance Criteria

1. THE Klantenbeheer_Systeem SHALL een Klant tabel gebruiken met de volgende velden: id, voornaam, achternaam, telefoonnummer, email, geboortedatum, adres, postcode, woonplaats, aangemaakt_op, bijgewerkt_op
2. THE Klantenbeheer_Systeem SHALL het veld id als primaire sleutel gebruiken met auto-increment
3. THE Klantenbeheer_Systeem SHALL de velden voornaam, achternaam, telefoonnummer en email als verplicht markeren
4. THE Klantenbeheer_Systeem SHALL de velden geboortedatum, adres, postcode en woonplaats als optioneel markeren
5. THE Klantenbeheer_Systeem SHALL het veld aangemaakt_op automatisch invullen bij het aanmaken van een Klant
6. THE Klantenbeheer_Systeem SHALL het veld bijgewerkt_op automatisch actualiseren bij elke wijziging van een Klant
