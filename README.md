# FansWage

##Deploy##

chown -R ec2-user:ec2-user /var/www/dev/fanwage
chmod -R 777 /var/www/dev/fanwage/app/tmp/cache
chmod -R 777 /var/www/dev/fanwage/app/tmp/logs

# Code fixing
php vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix app/Controller --rules=no_blank_lines_after_phpdoc
php vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix app/Controller/ --rules=visibility_required
no_blank_lines_after_class_opening
no_closing_tag
no_empty_comment
no_empty_phpdoc
no_empty_statement
no_extra_consecutive_blank_lines
no_mixed_echo_print
no_spaces_after_function_name
no_spaces_around_offset
no_spaces_inside_parenthesis
no_trailing_comma_in_list_call
no_trailing_comma_in_singleline_array
no_trailing_whitespace
no_trailing_whitespace_in_comment
no_unneeded_control_parentheses
no_unused_imports
no_useless_return
no_whitespace_before_comma_in_array
no_whitespace_in_blank_line
normalize_index_brace
object_operator_without_whitespace
phpdoc_add_missing_param_annotation
phpdoc_align
phpdoc_indent
phpdoc_inline_tag
phpdoc_order
phpdoc_separation
pow_to_exponentiation
single_quote
space_after_semicolon
standardize_not_equals
switch_case_semicolon_to_colon
ternary_operator_spaces
visibility_required
whitespace_after_comma_in_array
include

php vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix --allow-risky=yes --rules=no_php4_constructor app/

php vendor/friendsofphp/php-cs-fixer/php-cs-fixer --config=.php_cs fix --allow-risky=yes app/Controller/

* no_unreachable_default_argument_value
* no_useless_else
* ordered_class_elements
* pre_increment
* indentation_type

** phpdoc_scalar


CREATE USER 'fanswage_user'@'localhost' IDENTIFIED BY 'Eemo4Iz2';
GRANT ALL ON db_sportsproject.* TO 'fanswage_user'@'localhost';
FLUSH PRIVILEGES;
