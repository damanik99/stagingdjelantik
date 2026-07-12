<?php namespace App\Models;

use CodeIgniter\Model;

class ImportCsvFormModel extends Model
{
    public function rules()
	{
		return array(
			array(
				'file','file',
				'types'=>'csv',
				'maxSize'=>1024*1024*10,
				'tooLarge'=>'The File was larger than 10MB. Please Upload a smaller file.',
				'allowEmpty'=>false,
				'message'=>'Invalid file, Please select the file',
			),
			array('check', 'numerical', 'integerOnly'=>true),
			array('replacement', 'numerical', 'integerOnly'=>true),
			array('replacement_with_value', 'numerical', 'integerOnly'=>true),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'file'=>'SELECT FILE *',
			'check'=>'Check',
			'replacement'=>'Replacement',
			'replacement_with_value'=>'Replace Only Value'
		);
	}
	
	public function arrayValue($tempLoc)
	{
		// echo var_dump($tempLoc);exit;
		if ($tempLoc) 
		{
			$row = 1;
			$value = array();
			$column = array();
			if (($handle = fopen($tempLoc, "r")) !== FALSE)
			{
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
				{
					$num = count($data);
					$row++;
					for ($c=0; $c < $num; $c++)
						$colum[]= $data[$c];
				}
				fclose($handle);
			}
			
			if(strpos($colum[0],';'))
			{
				unset($colum);
				unset($num);	
				if (($handle = fopen($tempLoc, "r")) !== FALSE)
				{
					while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
					{
						$num = count($data);
						$row++;
						for ($c=0; $c < $num; $c++)
							$colum[]= $data[$c];
					}
					fclose($handle);
				}
			}
			
			$column = $colum;
			$columnHead = array();
			for($i=0;$i<$num;$i++)
			{
				$columnHead[] = trim(str_replace(' ','_',strtolower($column[$i])));
			}
			
			$columnValue = array();
			for($a=$num;$a<(count($column));$a++){
				$columnValue[] = trim($column[$a]);
			}
			
			$countColumn = count($columnValue)/$num;
			for($x=0;$x<$countColumn;$x++)
			{
				$rawValue = array_chunk($columnValue,$num);
				$arrValue[$x] = $rawValue[$x];
				
				if(count($arrValue[$x]) == count($columnHead))
					$value[$x] = array_combine($columnHead,$arrValue[$x]);
			}
			return $value;
		}
	}
	
	public function importCsv($values = array(), $returnMess = array())
	{
		
		if(count($values)>0)
		{
			for($i=0;$i<count($values);$i++)
			{
				// echo var_dump($returnMess);exit;
				$itemValue = array_push($values[$i],$returnMess[$i]);
				$item[] = $values[$i];
			}
			return $item;
		}
	}
	
	public function checkColumn($data = array())
	{
		$column = array();
		for($i=0;$i<count($data);$i++)
		{
			$datas[] = str_replace(';',',',$data[$i]);
			$explData[] = explode(',',$datas[$i]);
		}
		
		for($a=0;$a<count($explData);$a++)
		{
			for($b=0;$b<count($explData[$a]);$b++)
				$column[] = $explData[$a][$b];
		}
		
		return $column;
	}
	
	public function importPivotCsv($fileName, $constantField = array(), $pivotField = array())
	{
		$datas = $this->arrayValue($fileName);	
		
		$return = array();
		foreach($datas as $data)
		{
			$result = array();
			
			for($cf=0;$cf<count($constantField);$cf++)
			{
				$cField = $constantField[$cf];
				
				if(!is_null($result))
					$result[$cField] = $data[$cField];
			}
			
			$pivotArray = array_slice($data,count($constantField));
			$keyPivotArray = array_keys($pivotArray);
			for($i=0;$i<count($keyPivotArray);$i++)
			{
				$key = $keyPivotArray[$i];
				$value = $pivotArray[$key];
				
				$v1 = $pivotField[0];
				$v2 = $pivotField[1];
				
				$result[$v1] = $key;
				$result[$v2] = $value;
				
				if(!is_null($result))
					$return[] = $result;
			}
		}
		return $return;
	}

}