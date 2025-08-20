<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Helpers\RoleHelper;

class RoleHelperTest extends TestCase
{
    public function test_role_helper_has_permission()
    {
        // Test that DGM has permission to access student registration
        $this->assertTrue(RoleHelper::hasPermission('DGM', 'student.registration'));
        
        // Test that Librarian does not have permission to access student registration
        $this->assertFalse(RoleHelper::hasPermission('Librarian', 'student.registration'));
        
        // Test that Librarian has permission to access library clearance
        $this->assertTrue(RoleHelper::hasPermission('Librarian', 'library.clearance'));
    }

    public function test_role_helper_can_access_student_management()
    {
        // Test that DGM can access student management
        $this->assertTrue(RoleHelper::canAccessStudentManagement('DGM'));
        
        // Test that Librarian cannot access student management
        $this->assertFalse(RoleHelper::canAccessStudentManagement('Librarian'));
    }

    public function test_role_helper_can_access_clearance()
    {
        // Test that DGM can access clearance
        $this->assertTrue(RoleHelper::canAccessClearance('DGM'));
        
        // Test that Librarian can access clearance
        $this->assertTrue(RoleHelper::canAccessClearance('Librarian'));
        
        // Test that Student Counselor cannot access clearance
        $this->assertFalse(RoleHelper::canAccessClearance('Student Counselor'));
    }

    public function test_developer_role_has_full_access()
    {
        // Test that Developer has access to all major permissions
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'dashboard'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'create.user'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'user.management'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'module.management'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'course.management'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'student.registration'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'course.registration'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'attendance'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'special.approval'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'library.clearance'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'hostel.clearance.form.management'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'project.clearance.management'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'payment.plan'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'payment.clearance'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'reporting.dashboard'));
        $this->assertTrue(RoleHelper::hasPermission('Developer', 'data.export.import'));

    }

    public function test_developer_role_can_access_all_management_features()
    {
        // Test that Developer can access all management features
        $this->assertTrue(RoleHelper::canAccessStudentManagement('Developer'));
        $this->assertTrue(RoleHelper::canAccessClearance('Developer'));
        $this->assertTrue(RoleHelper::canAccessAcademicManagement('Developer'));
        $this->assertTrue(RoleHelper::canAccessAttendance('Developer'));
    }

    public function test_role_helper_can_access_academic_management()
    {
        // Test that DGM can access academic management
        $this->assertTrue(RoleHelper::canAccessAcademicManagement('DGM'));
        
        // Test that Program Administrator can access academic management
        $this->assertTrue(RoleHelper::canAccessAcademicManagement('Program Administrator'));
        
        // Test that Librarian cannot access academic management
        $this->assertFalse(RoleHelper::canAccessAcademicManagement('Librarian'));
    }

    public function test_role_helper_get_roles()
    {
        $roles = RoleHelper::getRoles();
        
        $this->assertArrayHasKey('DGM', $roles);
        $this->assertArrayHasKey('Program Administrator (level 01)', $roles);
        $this->assertArrayHasKey('Program Administrator (level 02)', $roles);
        $this->assertArrayHasKey('Student Counselor', $roles);
        $this->assertArrayHasKey('Librarian', $roles);
        $this->assertArrayHasKey('Hostel Manager', $roles);
        $this->assertArrayHasKey('Bursar', $roles);
        $this->assertArrayHasKey('Project Tutor', $roles);
        $this->assertArrayHasKey('Marketing Manager', $roles);
    }

    public function test_role_helper_get_role_permissions()
    {
        $dgmPermissions = RoleHelper::getRolePermissions('DGM');
        $librarianPermissions = RoleHelper::getRolePermissions('Librarian');
        
        // DGM should have more permissions than Librarian
        $this->assertGreaterThan(count($librarianPermissions), count($dgmPermissions));
        
        // DGM should have student.registration permission
        $this->assertContains('student.registration', $dgmPermissions);
        
        // Librarian should have library.clearance permission
        $this->assertContains('library.clearance', $librarianPermissions);
        
        // Librarian should not have student.registration permission
        $this->assertNotContains('student.registration', $librarianPermissions);
    }

    public function test_role_helper_can_access_attendance()
    {
        // Test that DGM can access attendance
        $this->assertTrue(RoleHelper::canAccessAttendance('DGM'));
        
        // Test that Project Tutor can access attendance
        $this->assertTrue(RoleHelper::canAccessAttendance('Project Tutor'));
        
        // Test that Librarian cannot access attendance
        $this->assertFalse(RoleHelper::canAccessAttendance('Librarian'));
    }
} 