<?php 

class Model extends Database
{
  	protected function get_allowed_columns($data)
	{
 
 		if(!empty($this->allowed_columns)){
			foreach ($data as $key => $value) {
				// code...
				if(!in_array($key, $this->allowed_columns))
				{
					unset($data[$key]);
				}
			}
		}

		return $data;
 	}


  public function insert($data)
  {
    	$clean_array = $this->get_allowed_columns($data,$this->table);
		$keys = array_keys($clean_array);
		
		$query = "insert into $this->table ";
		$query .= "(".implode(",", $keys) .") values ";
		$query .= "(:".implode(",:", $keys) .")";

		$db = new Database;
		$db->query($query,$clean_array);	
  }
	
  public function where($data,$limit = 10,$offset = 0,$order = "desc",$order_column = "id")
	{

		$keys = array_keys($data);
		
		$query = "select * from $this->table where ";

		foreach ($keys as $key) {
			// code...
			$query .= "$key = :$key && ";

			
		}

		$kyle = trim($query,"&& ");
		$kyle .= " order by $order_column $order limit $limit offset $offset";

		$db = new Database;
		return $db->query($kyle,$data);	

	}

	public function getAll($limit = 10,$offset = 0,$order = "desc",$order_column = "id")
	{

		$query = "select * from $this->table order by $order_column $order";
  		
		$db = new Database;
		return $db->query($query);	

	}
	public function getProducts($data)
	{
	//  $keys = array_keys($data);
	
	 $query = "select * from $this->table where ";

	 $db = new Database();
	 return $db->query($query,$data);
	
	
	
	}

		public function first($data)
	{

		$keys = array_keys($data);
		
		$query = "select * from $this->table where ";

		foreach ($keys as $key) {
			// code...
			$query .= "$key = :$key && ";
		}

		$query = trim($query,"&& ");

		$db = new Database;
		if($res = $db->query($query,$data))
		{
			return $res[0];
		}

		return false;	

	}

	public function insertOrder($data)
	{
		// Define the allowed columns for the orders table
		$this->allowed_columns = ['product_id', 'product_name', 'product_price', 'quantity'];

		// Clean the data to only include allowed columns
		$clean_array = $this->get_allowed_columns($data);
		$keys = array_keys($clean_array);

		// Prepare the SQL query
		$query = "INSERT INTO orders ";
		$query .= "(".implode(",", $keys) .") VALUES ";
		$query .= "(:".implode(",:", $keys) .")";

		// Create a new Database instance and execute the query
		$db = new Database;
		$db->query($query, $clean_array);
	}
}
	


