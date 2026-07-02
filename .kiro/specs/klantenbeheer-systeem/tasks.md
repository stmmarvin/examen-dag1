# Implementation Plan: Klantenbeheer Systeem

## Overview

This implementation plan breaks down the Laravel 13 CRUD application for customer management into discrete coding steps. The system uses Laravel Breeze for authentication, Eloquent ORM for database operations, and Blade templates with Tailwind CSS for the frontend. Each task builds incrementally on previous steps, with tests integrated throughout to validate functionality early.

## Tasks

- [x] 1. Set up database migration and model
  - [x] 1.1 Create klanten table migration
    - Create migration file with all required fields (id, voornaam, achternaam, telefoonnummer, email, geboortedatum, adres, postcode, woonplaats, allergieen, wensen, timestamps)
    - Define field types, nullable constraints, and indexes
    - _Requirements: 10.1, 10.2, 10.3, 10.4, 10.5, 10.6_
  
  - [x] 1.2 Create Klant Eloquent model
    - Create Klant model class with fillable fields
    - Configure date casting for geboortedatum
    - Add volledige_naam accessor for full name display
    - _Requirements: 10.1, 10.3, 10.4_
  
  - [ ]* 1.3 Create KlantFactory for test data
    - Create factory with Faker for generating realistic Dutch customer data
    - Include states for minimal (required only) and complete (all fields) customers
    - _Requirements: 10.1, 10.2, 10.3, 10.4_
  
  - [ ]* 1.4 Write unit tests for Klant model
    - Test mass assignment protection
    - Test date casting for geboortedatum
    - Test volledige_naam accessor
    - Test timestamp automatic management
    - _Requirements: 10.1, 10.5, 10.6_

- [x] 2. Create validation Form Requests
  - [x] 2.1 Create StoreKlantRequest for new customer validation
    - Define validation rules for all fields (required, email, regex for phone/postcode)
    - Add custom validation messages in Dutch
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5, 2.6_
  
  - [x] 2.2 Create UpdateKlantRequest for customer update validation
    - Define identical validation rules as StoreKlantRequest
    - Add custom validation messages in Dutch
    - _Requirements: 6.1, 6.2, 6.3, 6.4, 6.5, 6.6_
  
  - [ ]* 2.3 Write unit tests for StoreKlantRequest
    - Test valid data passes validation
    - Test missing required fields fail
    - Test invalid email format fails
    - Test invalid phone number format fails
    - Test invalid postcode format fails
    - Test valid optional fields are accepted
    - Test future birth dates are rejected
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5, 2.6_
  
  - [ ]* 2.4 Write unit tests for UpdateKlantRequest
    - Test same validation scenarios as StoreKlantRequest
    - _Requirements: 6.1, 6.2, 6.3, 6.4, 6.5, 6.6_

- [x] 3. Implement KlantController CRUD operations
  - [x] 3.1 Create KlantController with index method
    - Implement index method to retrieve all klanten from database
    - Return index view with klanten collection
    - _Requirements: 3.1, 3.2, 4.1, 4.2, 4.3_
  
  - [x] 3.2 Implement create method
    - Return create view with empty form
    - _Requirements: 1.4_
  
  - [x] 3.3 Implement store method
    - Accept StoreKlantRequest for validation
    - Create new Klant with validated data
    - Redirect to index with success message
    - _Requirements: 1.1, 1.2, 1.3, 1.5, 2.1, 2.2, 2.3, 2.4, 2.5, 2.6_
  
  - [x] 3.4 Implement show method
    - Use route model binding for automatic Klant retrieval
    - Return show view with klant details
    - _Requirements: 3.3_
  
  - [x] 3.5 Implement edit method
    - Use route model binding for automatic Klant retrieval
    - Return edit view with pre-filled klant data
    - _Requirements: 5.1, 5.5_
  
  - [x] 3.6 Implement update method
    - Accept UpdateKlantRequest for validation
    - Update existing Klant with validated data
    - Redirect to show or index with success message
    - _Requirements: 5.2, 5.3, 5.4, 5.5, 6.1, 6.2, 6.3, 6.4, 6.5, 6.6_
  
  - [x] 3.7 Implement destroy method
    - Use route model binding for automatic Klant retrieval
    - Delete klant from database
    - Redirect to index with success message
    - Handle non-existent klant with error message
    - _Requirements: 7.2, 7.3, 8.1, 8.2, 8.3_

- [x] 4. Define routes with authentication middleware
  - [x] 4.1 Register klanten resource routes in web.php
    - Define RESTful routes for KlantController
    - Apply auth middleware to all klanten routes
    - _Requirements: 9.1, 9.2, 9.3_
  
  - [ ]* 4.2 Write feature tests for authentication middleware
    - Test unauthenticated users redirected to login for all routes
    - Test authenticated users can access all routes
    - _Requirements: 9.1, 9.2, 9.3_

- [x] 5. Create Blade views for index and show
  - [x] 5.1 Create index.blade.php view
    - Display table with voornaam, achternaam, email for all klanten
    - Add "Nieuwe klant" button linking to create form
    - Add action buttons (view, edit, delete) for each klant
    - Implement empty state message when no klanten exist
    - Add delete confirmation using JavaScript
    - _Requirements: 3.1, 3.2, 3.4, 4.1, 4.2, 4.3, 7.1_
  
  - [x] 5.2 Create show.blade.php view
    - Display all klantgegevens in read-only format
    - Add Edit and Delete buttons
    - Add Back to list button
    - Format dates and optional fields appropriately
    - _Requirements: 3.3, 7.1_
  
  - [ ]* 5.3 Write feature tests for index route
    - Test authenticated user can view klanten index
    - Test index displays all klanten with required fields
    - Test index shows "Nieuwe klant" button
    - Test empty state displays when no klanten exist
    - Test empty state shows correct message
    - _Requirements: 3.1, 3.2, 3.4, 4.1, 4.2, 4.3_
  
  - [ ]* 5.4 Write feature tests for show route
    - Test authenticated user can view klant details
    - Test all klant data is displayed
    - Test non-existent klant returns 404
    - _Requirements: 3.3_

- [ ] 6. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [x] 7. Create Blade views for create and edit forms
  - [x] 7.1 Create create.blade.php view
    - Build form with all klant fields (voornaam, achternaam, telefoonnummer, email, geboortedatum, adres, postcode, woonplaats, allergieen, wensen)
    - Add required field indicators for verplichte velden
    - Display validation errors using Breeze components
    - Add Save and Cancel buttons
    - _Requirements: 1.4, 2.1, 2.2_
  
  - [x] 7.2 Create edit.blade.php view
    - Build form identical to create form
    - Pre-fill form with current klant data
    - Display validation errors using Breeze components
    - Add Save and Cancel buttons
    - _Requirements: 5.1, 5.5, 6.1, 6.2_
  
  - [ ]* 7.3 Write feature tests for create route
    - Test authenticated user can view create form
    - Test form displays all required and optional fields
    - _Requirements: 1.4_
  
  - [ ]* 7.4 Write feature tests for edit route
    - Test authenticated user can view edit form
    - Test form is pre-filled with current klant data
    - Test non-existent klant returns 404
    - _Requirements: 5.1, 5.5_

- [ ] 8. Implement store functionality with validation
  - [ ]* 8.1 Write feature tests for store route
    - Test valid data creates new klant in database
    - Test new klant appears in index after creation
    - Test required fields are enforced
    - Test invalid email is rejected with error message
    - Test invalid phone number is rejected with error message
    - Test optional fields are saved correctly
    - Test timestamps are set automatically
    - Test success message is displayed after creation
    - _Requirements: 1.1, 1.2, 1.3, 1.5, 2.1, 2.2, 2.3, 2.4, 2.5, 2.6_

- [ ] 9. Implement update functionality with validation
  - [ ]* 9.1 Write feature tests for update route
    - Test valid data updates existing klant
    - Test updated data is reflected in database
    - Test updated_at timestamp is automatically updated
    - Test required fields cannot be emptied
    - Test invalid email is rejected during update
    - Test invalid phone number is rejected during update
    - Test success message is displayed after update
    - Test non-existent klant returns 404
    - _Requirements: 5.2, 5.3, 5.4, 5.5, 6.1, 6.2, 6.3, 6.4, 6.5, 6.6_

- [ ] 10. Implement delete functionality with confirmation
  - [ ]* 10.1 Write feature tests for delete route
    - Test authenticated user can delete klant
    - Test deleted klant is removed from database
    - Test deleted klant no longer appears in index
    - Test success message is displayed after deletion
    - Test attempting to delete non-existent klant shows "Klant niet gevonden"
    - _Requirements: 7.2, 7.3, 7.4, 7.5, 8.1, 8.2, 8.3_

- [ ] 11. Add error handling and user feedback
  - [-] 11.1 Implement flash messages for success operations
    - Add success messages for create, update, delete operations
    - Use Laravel session flash with Breeze notification component
    - _Requirements: 1.1, 5.2, 7.2_
  
  - [-] 11.2 Implement error handling for database operations
    - Catch QueryException in controller methods
    - Display generic error message to users
    - Log error details for debugging
    - _Requirements: 2.2, 6.2, 8.1_
  
  - [-] 11.3 Handle 404 errors for non-existent klanten
    - Verify route model binding handles missing klanten
    - Add custom "Klant niet gevonden" message for delete operations
    - _Requirements: 8.1, 8.2, 8.3_

- [ ] 12. Final integration and polish
  - [-] 12.1 Add navigation links to Breeze layout
    - Add "Klantenoverzicht" link to main navigation
    - Ensure consistent styling with Breeze components
    - _Requirements: 3.1_
  
  - [-] 12.2 Verify delete confirmation dialog
    - Test JavaScript confirmation appears with correct message
    - Ensure cancel preserves klant, confirm deletes klant
    - _Requirements: 7.1, 7.4, 7.5_
  
  - [ ]* 12.3 Create database seeder for development
    - Create KlantSeeder with sample customer data
    - Register seeder in DatabaseSeeder
    - _Requirements: 10.1_

- [ ] 13. Final checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for faster MVP delivery
- Each task references specific requirements for traceability
- Checkpoints ensure incremental validation at natural breaks
- This is a CRUD application - unit tests and feature tests provide comprehensive coverage
- Property-based tests are not appropriate for this feature (UI rendering, forms, database operations)
- Laravel's built-in authentication (Breeze) handles all security requirements
- Route model binding automatically handles 404s for non-existent klanten
- Form Request classes handle all validation automatically

## Task Dependency Graph

```json
{
  "waves": [
    { "id": 0, "tasks": ["1.1"] },
    { "id": 1, "tasks": ["1.2", "2.1", "2.2"] },
    { "id": 2, "tasks": ["1.3", "1.4", "2.3", "2.4", "3.1", "3.2"] },
    { "id": 3, "tasks": ["3.3", "3.4", "3.5", "3.6", "3.7", "4.1"] },
    { "id": 4, "tasks": ["4.2", "5.1", "5.2"] },
    { "id": 5, "tasks": ["5.3", "5.4", "7.1", "7.2"] },
    { "id": 6, "tasks": ["7.3", "7.4", "8.1"] },
    { "id": 7, "tasks": ["9.1", "10.1"] },
    { "id": 8, "tasks": ["11.1", "11.2", "11.3"] },
    { "id": 9, "tasks": ["12.1", "12.2", "12.3"] }
  ]
}
```
