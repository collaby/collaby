--
-- acl inserts
--

INSERT INTO acl_roles(id, role, parent) VALUES (1, 'visitor', null);
INSERT INTO acl_roles(id, role, parent) VALUES (2, 'user', 1);
INSERT INTO acl_roles(id, role, parent) VALUES (3, 'admin', 2);


INSERT INTO acl_modules(id, module) VALUES (1, 'Application');
INSERT INTO acl_modules(id, module) VALUES (2, 'Admin');


INSERT INTO acl_controllers(id, controller) VALUES (1, 'Index');
INSERT INTO acl_controllers(id, controller) VALUES (2, 'Auth');
INSERT INTO acl_controllers(id, controller) VALUES (3, 'Document');
INSERT INTO acl_controllers(id, controller) VALUES (4, 'User');
INSERT INTO acl_controllers(id, controller) VALUES (5, 'Account');
INSERT INTO acl_controllers(id, controller) VALUES (6, 'Dashboard');
INSERT INTO acl_controllers(id, controller) VALUES (7, 'Template');


INSERT INTO acl_actions(id, action) VALUES (1, 'index');
INSERT INTO acl_actions(id, action) VALUES (2, 'about');
INSERT INTO acl_actions(id, action) VALUES (3, 'login');
INSERT INTO acl_actions(id, action) VALUES (4, 'logout');
INSERT INTO acl_actions(id, action) VALUES (5, 'signup');
INSERT INTO acl_actions(id, action) VALUES (6, 'new');
INSERT INTO acl_actions(id, action) VALUES (7, 'edit');
INSERT INTO acl_actions(id, action) VALUES (8, 'export');
INSERT INTO acl_actions(id, action) VALUES (9, 'import');
INSERT INTO acl_actions(id, action) VALUES (10, 'clone');
INSERT INTO acl_actions(id, action) VALUES (11, 'view');


INSERT INTO acl_resources(id, module_id, controller_id, action_id) VALUES (1, 1, 1, 1);
INSERT INTO acl_resources(id, module_id, controller_id, action_id) VALUES (2, 1, 1, 2);
INSERT INTO acl_resources(id, module_id, controller_id, action_id) VALUES (3, 1, 2, 3);
INSERT INTO acl_resources(id, module_id, controller_id, action_id) VALUES (4, 1, 2, 4);
INSERT INTO acl_resources(id, module_id, controller_id, action_id) VALUES (5, 1, 5, 5);
INSERT INTO acl_resources(id, module_id, controller_id, action_id) VALUES (6, 1, 3, 6);
INSERT INTO acl_resources(id, module_id, controller_id, action_id) VALUES (7, 1, 3, 7);
INSERT INTO acl_resources(id, module_id, controller_id, action_id) VALUES (8, 1, 3, 8);
INSERT INTO acl_resources(id, module_id, controller_id, action_id) VALUES (9, 1, 3, 9);
INSERT INTO acl_resources(id, module_id, controller_id, action_id) VALUES (10, 1, 3, 10);
INSERT INTO acl_resources(id, module_id, controller_id, action_id) VALUES (11, 1, 4, 11);
INSERT INTO acl_resources(id, module_id, controller_id, action_id) VALUES (12, 2, 6, 1);
INSERT INTO acl_resources(id, module_id, controller_id, action_id) VALUES (13, 2, 7, 1);


INSERT INTO acl_privileges(resource_id, role_id, allow) VALUES (1, 1, true);
INSERT INTO acl_privileges(resource_id, role_id, allow) VALUES (2, 1, true);
INSERT INTO acl_privileges(resource_id, role_id, allow) VALUES (3, 1, true);
INSERT INTO acl_privileges(resource_id, role_id, allow) VALUES (4, 2, true);
INSERT INTO acl_privileges(resource_id, role_id, allow) VALUES (5, 1, true);
INSERT INTO acl_privileges(resource_id, role_id, allow) VALUES (6, 2, true);
INSERT INTO acl_privileges(resource_id, role_id, allow) VALUES (7, 2, true);
INSERT INTO acl_privileges(resource_id, role_id, allow) VALUES (8, 2, true);
INSERT INTO acl_privileges(resource_id, role_id, allow) VALUES (9, 2, true);
INSERT INTO acl_privileges(resource_id, role_id, allow) VALUES (10, 2, true);
INSERT INTO acl_privileges(resource_id, role_id, allow) VALUES (11, 1, true);
INSERT INTO acl_privileges(resource_id, role_id, allow) VALUES (12, 3, true);
INSERT INTO acl_privileges(resource_id, role_id, allow) VALUES (13, 3, true);
