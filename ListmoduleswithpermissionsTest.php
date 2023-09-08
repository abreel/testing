<?php
use Tests\TestCase;

class AclControllerListmoduleswithpermissionsTest extends TestCase
{
    /**
     * A test for the listModulesWithPermissions method.
     *
     * @return void
     */
    public function testListModulesWithPermissionsWithModuleIdAndSearch()
    {
        $module_id = 1;
        $search = 'findme';

        $response = $this->postJson('/api/v1/core/acl/list-modules-with-permissions', [
            'module_id' => $module_id,
            'search' => $search
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $module_id,
                    'name' => $search,
                    'permissions' => [
                        'id' => $module_id,
                        'name' => $search,
                        'module_id' => $module_id
                    ]
                ]
            ]);
    }

    /**
     * A test for the listModulesWithPermissions method with no search provided.
     *
     * @return void
     */
    public function testListModulesWithPermissionsWithNoSearch()
    {
        $module_id = 1;

        $response = $this->postJson('/api/v1/core/acl/list-modules-with-permissions', [
            'module_id' => $module_id
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $module_id,
                    'permissions' => []
                ]
            ]);
    }
}
