SELECT @option_group_id_contrib_status := max(id) from civicrm_option_group where name = 'contribution_status';
SELECT @contributeCompId := max(id) FROM civicrm_component where name = 'CiviContribute';
SELECT @option_group_id_contrib_status_wt  := MAX(weight) FROM civicrm_option_value WHERE option_group_id = @option_group_id_contrib_status;
SELECT @option_group_id_contrib_status_val  := MAX(CAST(value as UNSIGNED)) FROM civicrm_option_value WHERE option_group_id = @option_group_id_contrib_status;

INSERT INTO
   civicrm_option_value (option_group_id, label, value, name, grouping, filter, is_default, weight, description, is_optgroup, is_reserved, is_active, component_id, visibility_id)
VALUES
   (@option_group_id_contrib_status, 'Partially refunded', @option_group_id_contrib_status_val+1, 'Partially refunded', NULL, 0, NULL, @option_group_id_contrib_status_wt+1, NULL, 0, 1, 1, NULL, NULL);

