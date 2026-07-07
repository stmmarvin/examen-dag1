# Design Document: Customer Registration and Login System

## Overview

This design document specifies the architecture for a customer registration and login system built on Laravel 11 with Breeze authentication scaffolding. The system provides customer registration with personal details (voornaam, achternaam, email, telefoon, password) and authentication capabilities, persisting data to a MySQL database for use by other team members in subsequent project phases.

## Architecture

### System Components

The system follows Laravel's MVC architecture with these core components:

1. **Routes Layer** (`routes/auth.php`)
   - Registration routes: GET/POST `/register`
   - Login routes: GET/POST `/login`
   - Logout route: POST `/logout`

2. **Controller Layer**
   - `RegisteredUserController`: Handles registration flow
   - `AuthenticatedSessionController`: Handles login/logout flow

3. **Request Validation Layer**
   - Registration validation in `RegisteredUserController@store`
   - Login validation in `LoginRequest`

4. **Model Layer**
   - `User` model (Eloquent ORM)
   - Implements Laravel Authenticatable contract

5. **Database Layer**
   - `users` table
   - `sessions` table
   - `password_reset_tokens` table

### Data Flow

#### Registration Flow

```
User submits form
    ↓
RegisteredUserController@store
    ↓
Validate input (voornaam, achternaam, email, telefoon, password)
    ↓
Create User record in database
    ↓
Fire Registered event
    ↓
Auto-login user (Auth::login)
    ↓
Redirect to dashboard
```

#### Login Flow

```
User submits credentials
    ↓
AuthenticatedSessionController@store
    ↓
LoginRequest validation
    ↓
Authenticate via Auth::attempt()
    ↓
Regenerate session
    ↓
Redirect to dashboard
```

## Components

### 1. RegisteredUserController

**Purpose:** Manages customer registration process

**Methods:**

```php
public function create(): View
```
- Displays registration form
- Returns: `auth.register` view

```php
public function store(Request $request): RedirectResponse
```
- Validates registration input
- Creates new User record
- Fires `Registered` event
- Auto-authenticates user
- Redirects to dashboard

**Validation Rules:**
```php
[
    'voornaam' => ['required', 'string', 'max:255'],
    'achternaam' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
    'telefoon' => ['nullable', 'string', 'max:20'],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
]
```

**User Creation:**
```php
User::create([
    'name' => $request->voornaam . ' ' . $request->achternaam,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'voornaam' => $request->voornaam,
    'achternaam' => $request->achternaam,
    'telefoon' => $request->telefoon,
    'rolename' => 'klant', // Default value set programmatically
]);
```

### 2. AuthenticatedSessionController

**Purpose:** Manages customer authentication (login/logout)

**Methods:**

```php
public function create(): View
```
- Displays login form
- Returns: `auth.login` view

```php
public function store(LoginRequest $request): RedirectResponse
```
- Validates credentials via LoginRequest
- Authenticates user via `Auth::attempt()`
- Regenerates session for security
- Redirects to intended route or dashboard

```php
public function destroy(Request $request): RedirectResponse
```
- Logs out user
- Invalidates session
- Regenerates CSRF token
- Redirects to home page

### 3. User Model

**Purpose:** Represents customer entity in the system

**Configuration:**

```php
#[Fillable(['name', 'email', 'password', 'rolename', 'voornaam', 'achternaam', 'telefoon'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
```

**Fillable Attributes:** Allows mass assignment of voornaam, achternaam, telefoon, name, email, password, rolename

**Hidden Attributes:** Protects password and remember_token from serialization

**Casts:** Auto-hashes password, converts email_verified_at to Carbon datetime

## Data Models

### Users Table Schema

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();                              // Primary key
    $table->string('name');                    // Full name (computed from voornaam + achternaam)
    $table->string('email')->unique();         // Unique email address
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');                // Hashed password
    $table->string('voornaam');                // First name (added in migration)
    $table->string('achternaam');              // Last name (added in migration)
    $table->string('telefoon')->nullable();    // Phone number (optional, added in migration)
    $table->string('rolename', 20)->nullable(false); // Role (allows null OR has default)
    $table->rememberToken();
    $table->timestamps();                      // created_at, updated_at
});
```

**Key Constraints:**
- `email`: UNIQUE index for uniqueness enforcement
- `voornaam`, `achternaam`: NOT NULL (required fields)
- `telefoon`: NULLABLE (optional field)
- `rolename`: Configuration allows either nullable OR default value (implementation detail)
- `password`: Automatically hashed via model cast

### Data Integrity

**Email Uniqueness:** Enforced at two levels:
1. Database level: UNIQUE constraint on email column
2. Application level: Laravel validation rule `unique:users`

**Password Security:**
- Passwords hashed using `Hash::make()` before storage
- Laravel uses bcrypt by default (via `password` cast)
- Plain-text passwords never stored

**Telefoon Optional:** NULL values allowed, no validation beyond max length

## Interfaces

### Registration Form Interface

**Route:** `GET /register`

**Form Fields:**
- `voornaam` (text, required, max 255)
- `achternaam` (text, required, max 255)
- `email` (email, required, unique, max 255)
- `telefoon` (text, optional, max 20)
- `password` (password, required)
- `password_confirmation` (password, required)

**Submit Action:** `POST /register`

**Success Response:** Redirect to `/dashboard` with authenticated session

**Error Response:** Redirect back with validation errors

### Login Form Interface

**Route:** `GET /login`

**Form Fields:**
- `email` (email, required)
- `password` (password, required)
- `remember` (checkbox, optional)

**Submit Action:** `POST /login`

**Success Response:** Redirect to intended route or `/dashboard` with authenticated session

**Error Response:** Redirect back with authentication error

## Error Handling

### Validation Errors

**Registration Validation Failures:**
- Missing required fields (voornaam, achternaam, email, password)
- Invalid email format
- Email already exists (uniqueness violation)
- Password confirmation mismatch
- Field length exceeded (voornaam, achternaam, email > 255 chars)

**Error Response Format:**
```php
// Laravel redirects back with errors
redirect()->back()->withErrors($validator)->withInput();
```

**Error Display:**
- Rendered in Blade views via `@error` directive
- Flash data preserves input (except password)

### Authentication Errors

**Login Failures:**
- Invalid email (user not found)
- Incorrect password
- Account locked/disabled (if implemented)

**Error Response:**
```php
throw ValidationException::withMessages([
    'email' => __('auth.failed'),
]);
```

**Throttling:**
- Laravel Breeze includes rate limiting via `ThrottleRequests` middleware
- Default: 5 attempts per minute per email

### Database Errors

**Duplicate Email Handling:**
- Caught by validation before database query
- If validation bypassed, database UNIQUE constraint throws exception
- Laravel converts to validation error automatically via exception handler

**Connection Failures:**
- Handled by Laravel's exception handler
- Returns 500 error page in production
- Detailed error in development (via debug mode)

## Security Considerations

### Password Security

1. **Hashing:** Bcrypt via `Hash::make()` and `password` cast
2. **Confirmation:** Required via `confirmed` validation rule
3. **Complexity:** Enforced via `Rules\Password::defaults()` (configurable)
4. **Storage:** Plain-text passwords never persisted

### Session Security

1. **Regeneration:** Session ID regenerated on login (`$request->session()->regenerate()`)
2. **CSRF Protection:** All POST requests require valid CSRF token
3. **Secure Cookies:** Configured in `config/session.php`
4. **HttpOnly Flag:** Prevents JavaScript access to session cookie

### Input Validation

1. **Server-Side Validation:** All inputs validated before processing
2. **Email Sanitization:** Forced to lowercase via `lowercase` rule
3. **SQL Injection Prevention:** Eloquent ORM uses parameterized queries
4. **XSS Prevention:** Blade templates auto-escape output

### Rate Limiting

**Login Throttling:**
- Implemented via `RateLimiter` in `LoginRequest`
- Prevents brute-force attacks
- Locks account temporarily after failed attempts

## Database Migration Strategy

### Required Migrations

**Migration 1:** Add customer fields to users table
```php
// database/migrations/YYYY_MM_DD_add_customer_fields_to_users_table.php
Schema::table('users', function (Blueprint $table) {
    $table->string('voornaam')->after('name');
    $table->string('achternaam')->after('voornaam');
    $table->string('telefoon')->nullable()->after('achternaam');
});
```

**Migration 2:** Modify rolename constraint (if needed)
```php
// Option A: Make nullable
Schema::table('users', function (Blueprint $table) {
    $table->string('rolename', 20)->nullable()->change();
});

// Option B: Add default value
Schema::table('users', function (Blueprint $table) {
    $table->string('rolename', 20)->default('klant')->change();
});
```

### Rollback Strategy

```php
public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['voornaam', 'achternaam', 'telefoon']);
        // Restore rolename constraint if modified
    });
}
```

## Testing Strategy

The system will be tested using both unit tests and property-based tests:

**Unit Tests:**
- Route accessibility (registration/login pages load)
- Specific validation scenarios
- Integration between components
- Edge cases (empty strings, boundary values)

**Property-Based Tests:**
- Field validation across random inputs
- Data persistence round-trips
- Authentication behavior with generated users
- Error handling with invalid data combinations

Minimum 100 iterations per property test due to randomization.

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system—essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property 1: Registration field validation

*For any* registration data submitted to the Registration_System, the system SHALL accept voornaam and achternaam as required string fields with maximum length of 255 characters, email as a required unique string field with valid email format, telefoon as an optional string field, and password as a required confirmed string field meeting password complexity requirements

**Validates: Requirements 1.1, 1.2, 1.3, 1.4, 1.5**

### Property 2: Email uniqueness enforcement

*For any* email address, if a user is successfully registered with that email, then any subsequent registration attempt with the same email SHALL be rejected with a validation error and no duplicate user record SHALL be created in the Users_Table

**Validates: Requirements 1.7**

### Property 3: Registration data persistence

*For any* valid registration data (voornaam, achternaam, email, telefoon, password), when submitted to the Registration_System, all fields SHALL be persisted to the Users_Table with the password stored as a hash (not plain-text) and when queried from the database, all non-password fields SHALL match the submitted values

**Validates: Requirements 1.6, 2.5**

### Property 4: Post-registration authentication and redirect

*For any* valid registration data, when successfully submitted to the Registration_System, the customer SHALL be automatically authenticated and the response SHALL redirect to the dashboard route

**Validates: Requirements 4.1, 4.2, 4.3**

### Property 5: Successful login authentication

*For any* registered user, when valid credentials (correct email and password) are submitted to the Login_System, the system SHALL authenticate the customer and redirect to the dashboard route

**Validates: Requirements 5.1, 5.2, 5.4**

### Property 6: Failed login authentication

*For any* invalid credential combination (non-existent email, incorrect password, or malformed input), when submitted to the Login_System, the system SHALL return an authentication error and SHALL NOT grant access

**Validates: Requirements 5.3**

### Property 7: Rolename not required for registration

*For any* valid registration data submitted without a rolename field, the Registration_System SHALL successfully create a user record without requiring rolename validation

**Validates: Requirements 6.1, 6.2**

## Implementation Notes

### Existing Code Leverage

The system leverages Laravel Breeze authentication scaffolding:
- Controllers already exist in `app/Http/Controllers/Auth/`
- Routes defined in `routes/auth.php`
- Views in `resources/views/auth/`

**Modifications Required:**
1. Update `RegisteredUserController@store` validation rules
2. Add voornaam, achternaam, telefoon to User::create() call
3. Update registration view to include new fields
4. Run migration to add columns to users table
5. Update User model fillable array

### Configuration Files

**User Model:** `app/Models/User.php`
- Already configured with fillable attributes including voornaam, achternaam, telefoon
- Password auto-hashing via cast

**Auth Config:** `config/auth.php`
- Default guard: `web` (session-based)
- Provider: `users` (Eloquent)
- Password reset settings

**Session Config:** `config/session.php`
- Driver: `database`
- Lifetime: 120 minutes
- Secure, HttpOnly, SameSite flags

### Environment Variables

Required in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

SESSION_DRIVER=database
```

## Deployment Considerations

### Database Setup

1. Run migrations: `php artisan migrate`
2. Verify users table has voornaam, achternaam, telefoon columns
3. Verify rolename constraint allows null or has default value
4. Test connection and permissions

### Session Storage

- Sessions stored in database (`sessions` table)
- Ensure table exists (created by Laravel migration)
- Consider periodic cleanup of expired sessions

### Cache and Queue

- Not required for basic registration/login
- Can add queue for `Registered` event if sending welcome emails

### Performance

- Email uniqueness check uses database index (fast)
- Password hashing is CPU-intensive (intentional security feature)
- Consider Redis for session storage at scale

## Future Enhancements

While not part of this specification, future phases may include:

1. Email verification workflow
2. Password reset functionality (already scaffolded by Breeze)
3. Profile management (update voornaam, achternaam, telefoon)
4. Account deletion
5. Two-factor authentication
6. Social login integration
7. Role-based access control (using rolename field)
8. Remember me functionality (already supported by Breeze)

## Conclusion

This design provides a complete customer registration and login system built on Laravel's robust authentication foundation. The architecture follows Laravel conventions, leverages existing Breeze scaffolding, and ensures secure handling of customer data. The system stores voornaam, achternaam, email, telefoon, and password for each customer, making this data available for other team members to use in subsequent project phases.
