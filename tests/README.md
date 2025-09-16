# Testing Documentation

This document describes the testing approach for the Timesheet MainController store function.

## Test Files Created

### 1. Feature Test: `tests/Feature/Timesheet/MainControllerStoreTest.php`
This test file tests the complete HTTP request/response cycle for the store function, including:
- Validation rules
- Database interactions
- HTTP responses
- Integration with middleware and validation

**Test Cases:**
- `test_store_timesheet_with_tutor_program_successfully()` - Tests successful timesheet creation for tutor programs
- `test_store_timesheet_with_mentor_program_successfully()` - Tests successful timesheet creation for mentor programs
- `test_store_timesheet_validation_fails_with_invalid_data()` - Tests validation failures with invalid data
- `test_store_timesheet_validation_fails_with_missing_required_fields()` - Tests validation failures with missing required fields
- `test_store_timesheet_creates_temp_user_roles_with_correct_year()` - Tests TempUserRoles creation with correct year
- `test_store_timesheet_updates_existing_temp_user_roles()` - Tests updating existing TempUserRoles

### 2. Unit Test: `tests/Unit/Timesheet/MainControllerStoreUnitTest.php`
This test file focuses on testing the business logic of the store function in isolation, including:
- Controller method logic
- Dependency injection
- Mocking of external services
- Business rule validation

**Test Cases:**
- `test_store_method_creates_tutor_temp_user_roles_correctly()` - Tests TempUserRoles creation for tutors
- `test_store_method_creates_mentor_temp_user_roles_correctly()` - Tests TempUserRoles creation for mentors
- `test_store_method_updates_existing_temp_user_roles()` - Tests updating existing TempUserRoles
- `test_store_method_handles_null_optional_fields()` - Tests handling of null optional fields
- `test_store_method_calls_create_timesheet_service_with_correct_parameters()` - Tests service method calls

## Factories Created

### 1. `database/factories/Ref_ProgramFactory.php`
Factory for creating Ref_Program test data with realistic default values.

### 2. `database/factories/PackageFactory.php`
Factory for creating Package test data for timesheet packages.

### 3. `database/factories/CurriculumFactory.php`
Factory for creating Curriculum test data.

## Running the Tests

### Run All Tests
```bash
php artisan test
```

### Run Specific Test Files
```bash
# Run only the feature tests
php artisan test tests/Feature/Timesheet/MainControllerStoreTest.php

# Run only the unit tests
php artisan test tests/Unit/Timesheet/MainControllerStoreUnitTest.php
```

### Run Specific Test Methods
```bash
# Run a specific test method
php artisan test --filter test_store_timesheet_with_tutor_program_successfully

# Run tests matching a pattern
php artisan test --filter "test_store_timesheet_with_tutor"
```

### Run Tests with Coverage
```bash
# Run tests with coverage report
php artisan test --coverage

# Run tests with coverage and generate HTML report
php artisan test --coverage --coverage-html coverage/
```

## Test Dependencies

The tests use the following Laravel testing features:
- `RefreshDatabase` trait for database isolation
- `WithFaker` trait for generating fake data
- Mocking for external dependencies
- Database assertions for verifying data persistence

## Test Data Setup

Each test creates its own test data using factories to ensure:
- Tests are isolated from each other
- Tests have consistent, predictable data
- Tests can be run in any order
- Tests clean up after themselves

## Mocking Strategy

The tests use mocking for:
- `SelectOrRegisterMentorTutorAction` - To avoid external API calls
- `CreateTimesheetService` - To isolate the controller logic
- `TimesheetDataService` - To avoid database queries in unit tests

## Validation Testing

The feature tests verify that:
- Required fields are properly validated
- Field formats are validated (email, UUID, etc.)
- Database existence rules are enforced
- Custom validation rules work correctly

## Business Logic Testing

The unit tests verify that:
- TempUserRoles are created with correct attributes
- Different program types (Tutor vs Mentor) are handled correctly
- Existing records are updated rather than duplicated
- Service methods are called with correct parameters
- Response format is correct

## Best Practices Implemented

1. **Test Isolation**: Each test creates its own data and cleans up
2. **Descriptive Names**: Test method names clearly describe what they test
3. **Arrange-Act-Assert**: Clear structure for test methods
4. **Mocking**: External dependencies are mocked to focus on unit logic
5. **Database Assertions**: Verify that data is properly persisted
6. **Edge Cases**: Test both success and failure scenarios
7. **Validation**: Test input validation thoroughly
