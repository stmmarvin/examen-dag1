# Implementation Plan: Customer Registration and Login System

## Overview

This plan implements a customer registration and login system for the Kniploket Tiko Laravel application. The implementation modifies the existing Laravel Breeze authentication scaffolding to support additional customer fields (voornaam, achternaam, telefoon) and removes the rolename requirement from registration. All code modifications will be made to existing controllers, models, migrations, and views.

## Tasks

- [ ] 1. Set up database schema and User model
  - [ ] 1.1 Verify and update migration for customer fields in users table
    - Verify the migration `add_customer_fields_to_users_table.php` exists
    - Ensure columns: voornaam (string), achternaam (string), telefoon (nullable string)
    - Ensure rolename allows NULL or has a default value
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 6.3_
  
  - [ ] 1.2 Update User model fillable attributes
    - Add voornaam, achternaam, telefoon to the fillable array in `app/Models/User.php`
    - Verify password cast is configured for auto-hashing
    - _Requirements: 3.1, 3.2, 3.3, 3.4_
  
  - [ ]* 1.3 Write property test for registration field validation (Property 1)
    - **Property 1: Registration field validation**
    - **Validates: Requirements 1.1, 1.2, 1.3, 1.4, 1.5**
    - Generate random valid/invalid registration data combinations
    - Test voornaam and achternaam required, max 255 characters
    - Test email required, unique, valid format, max 255 characters
    - Test telefoon optional, string
    - Test password required, confirmed, meets complexity requirements
    - Minimum 100 iterations

- [ ] 2. Implement registration controller logic
  - [ ] 2.1 Update RegisteredUserController validation rules
    - Modify the store() method in `app/Http/Controllers/Auth/RegisteredUserController.php`
    - Add validation rules for voornaam (required, string, max:255)
    - Add validation rules for achternaam (required, string, max:255)
    - Update email validation (required, string, lowercase, email, max:255, unique:users)
    - Add validation rules for telefoon (nullable, string, max:20)
    - Ensure password validation (required, confirmed, Password::defaults())
    - Remove rolename from validation rules
    - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 6.1_
  
  - [ ] 2.2 Update User creation logic in RegisteredUserController
    - Modify User::create() call to include voornaam, achternaam, telefoon
    - Set name field as concatenation of voornaam and achternaam
    - Set default rolename value programmatically ('klant') if needed
    - Ensure password is hashed using Hash::make()
    - _Requirements: 1.6, 2.5, 6.2_
  
  - [ ]* 2.3 Write property test for email uniqueness enforcement (Property 2)
    - **Property 2: Email uniqueness enforcement**
    - **Validates: Requirements 1.7**
    - Register a user with a random email
    - Attempt to register another user with the same email
    - Assert second registration fails with validation error
    - Assert no duplicate user record created
    - Minimum 100 iterations
  
  - [ ]* 2.4 Write property test for registration data persistence (Property 3)
    - **Property 3: Registration data persistence**
    - **Validates: Requirements 1.6, 2.5**
    - Generate random valid registration data
    - Submit registration
    - Query database for created user
    - Assert all fields match submitted data (voornaam, achternaam, email, telefoon)
    - Assert password is hashed (not plain-text)
    - Minimum 100 iterations

- [ ] 3. Update registration view
  - [ ] 3.1 Add customer fields to registration form
    - Modify `resources/views/auth/register.blade.php`
    - Add form input for voornaam (text, required, max 255)
    - Add form input for achternaam (text, required, max 255)
    - Update email input (email, required, max 255)
    - Add form input for telefoon (text, optional, max 20)
    - Ensure password and password_confirmation fields present
    - Remove rolename field if present
    - Add @error directives for each field to display validation errors
    - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 6.1_

- [ ] 4. Checkpoint - Run migrations and verify registration
  - Run `php artisan migrate` to apply database changes
  - Test registration flow manually or via automated test
  - Ensure all tests pass, ask the user if questions arise

- [ ] 5. Implement post-registration authentication and navigation
  - [ ] 5.1 Verify post-registration redirect logic
    - Check RegisteredUserController store() method calls Auth::login($user)
    - Verify redirect to route('dashboard') after successful registration
    - Ensure Registered event is fired
    - _Requirements: 4.1, 4.2, 4.3_
  
  - [ ]* 5.2 Write property test for post-registration authentication and redirect (Property 4)
    - **Property 4: Post-registration authentication and redirect**
    - **Validates: Requirements 4.1, 4.2, 4.3**
    - Generate random valid registration data
    - Submit POST request to /register
    - Assert user is authenticated (Auth::check())
    - Assert response redirects to dashboard route
    - Minimum 100 iterations

- [ ] 6. Verify and test login functionality
  - [ ] 6.1 Verify LoginRequest validation
    - Check `app/Http/Requests/Auth/LoginRequest.php` validates email and password
    - Ensure rate limiting is configured
    - Ensure no rolename requirement in login flow
    - _Requirements: 5.1, 6.1_
  
  - [ ] 6.2 Verify AuthenticatedSessionController login logic
    - Check store() method in `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
    - Verify Auth::attempt() is called with email and password
    - Verify session regeneration on successful login
    - Verify redirect to intended route or dashboard
    - _Requirements: 5.2, 5.4_
  
  - [ ]* 6.3 Write property test for successful login authentication (Property 5)
    - **Property 5: Successful login authentication**
    - **Validates: Requirements 5.1, 5.2, 5.4**
    - Create a user with random valid credentials
    - Submit POST request to /login with correct credentials
    - Assert user is authenticated (Auth::check())
    - Assert response redirects to dashboard route
    - Minimum 100 iterations
  
  - [ ]* 6.4 Write property test for failed login authentication (Property 6)
    - **Property 6: Failed login authentication**
    - **Validates: Requirements 5.3**
    - Generate random invalid credential combinations (wrong email, wrong password, malformed input)
    - Submit POST request to /login
    - Assert user is NOT authenticated
    - Assert authentication error is returned
    - Minimum 100 iterations

- [ ]* 7. Write property test for rolename not required (Property 7)
  - **Property 7: Rolename not required for registration**
  - **Validates: Requirements 6.1, 6.2**
  - Generate random valid registration data WITHOUT rolename field
  - Submit registration request
  - Assert user record is created successfully
  - Assert no validation error for missing rolename
  - Minimum 100 iterations

- [ ] 8. Final checkpoint - Comprehensive testing
  - Ensure all property tests pass (if implemented)
  - Ensure all unit tests pass
  - Verify registration flow end-to-end
  - Verify login flow end-to-end
  - Verify data persists correctly in database
  - Ask the user if questions arise

## Notes

- Tasks marked with `*` are optional and can be skipped for faster MVP
- Each task references specific requirements for traceability
- Property tests validate universal correctness properties across random inputs (minimum 100 iterations)
- Unit tests validate specific examples and edge cases
- The system leverages existing Laravel Breeze scaffolding - modifications are minimal
- All migrations should be tested in development before production deployment
- Ensure `.env` is configured with correct database credentials
- Session storage uses database driver - verify sessions table exists

## Task Dependency Graph

```json
{
  "waves": [
    { "id": 0, "tasks": ["1.1", "1.2"] },
    { "id": 1, "tasks": ["1.3", "2.1"] },
    { "id": 2, "tasks": ["2.2", "3.1"] },
    { "id": 3, "tasks": ["2.3", "2.4", "5.1"] },
    { "id": 4, "tasks": ["5.2", "6.1"] },
    { "id": 5, "tasks": ["6.2"] },
    { "id": 6, "tasks": ["6.3", "6.4", "7"] }
  ]
}
```
