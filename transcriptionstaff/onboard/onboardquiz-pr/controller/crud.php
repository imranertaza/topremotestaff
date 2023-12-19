<?php
class Crud{
	public function add($tablename, $data) {

		$key = array_keys($data);
		$val = array_values($data);
		
		$query = "INSERT INTO $tablename (" . implode(', ', $key) . ") "
			 . "VALUES ('" . implode("', '", $val) . "')";

		return $query;

	}
	public function getData($tablename, $column , $value) {

		$allValue = "";
		for($x = 0; $x < count($column) ;$x++){
				
				if($x == 0){
					$allValue = $allValue . $column[$x] . "=" . "'" . $value[$x] . "'";
				}else{
					$allValue = $allValue . " AND " . $column[$x] . "=" . "'" . $value[$x] . "'";
				}
				
		}
		$query = "SELECT * FROM $tablename WHERE $allValue";

		return $query;

	}
	public function delete($tablename, $column , $value) {

		$query = "DELETE FROM $tablename WHERE $column='$value'";

		return $query;

	}
	public function deleteAll($tablename, $column , $value) {

		$query = "DELETE FROM $tablename WHERE $column IN ($value)";

		return $query;

	}
	public function searchLike($tablename, $search_by , $search_keyword) {

		$query = "SELECT * FROM $tablename WHERE $search_by LIKE '$search_keyword%'";

		return $query;

	}
	public function updateAll($tablename, $column, $column_value , $value_name, $value) {

		$query = "UPDATE $tablename SET $column = '$column_value' WHERE $value_name IN ($value)";

		return $query;

	}
	public function update($tablename, $data, $id_field, $id_value) {
		foreach ($data as $field=>$value) {
			$fields[] = sprintf("`%s` = '%s'", $field, $value);
		}
		$field_list = join(',', $fields);
		
		$query = sprintf("UPDATE `%s` SET %s WHERE `%s` = %s", $tablename, $field_list, $id_field, "'" . $id_value . "'");
		
		return $query;
	}
	public function view($filename, $vars = null) {
	  if (is_array($vars) && !empty($vars)) {
		extract($vars);
	  }
	  ob_start();
	  include $filename;
	  return ob_get_clean();
	}
}

?>