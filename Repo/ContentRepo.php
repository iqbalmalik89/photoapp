<?php

class ContentRepo
{
	public function addContent($request)
	{
		$response = 400;
		if(!empty($request))
		{
			$values = array('content' => $request['content']);
			$query = $GLOBALS['con']->insertInto('content',$values)->execute();
			$response = 200;
		}
		else
		{
			$response = 400;
		}
		return $response;
	}

	public function getContent($request)
	{
		$requestData = $request;
			// Initial response is bad request
			$response = 400;

			// If there is some data in json form
			if(!empty($requestData['id']))
			{				
				$count = $GLOBALS['con']->from('content')->where('id',$request['id'])->count();
				if($count > 0)
				{
					$exists = $GLOBALS['con']->from('content')->where('id',$requestData['id']);
					$data = array();

					foreach($exists as $content)
			    	{
						$data[] = $content;
					}

					$response = 200;
				}
				else
				{
					$data = array();
					$response = 400;
				}
			}
			
			else
			{
				
				$exists = $GLOBALS['con']->from('content');
				$data = array();

				foreach($exists as $content)
		    	{
					$data[] = $content;
				}

				$response = 200;
					
			}
			
			return array('code' => $response,'data' => $data);
	}

	public function deleteContent($request)
	{
		$id = $request['id'];
		$response = 400;

		if(!empty($id))
		{
			$exists = $GLOBALS['con']->from('content')->where('id',$id)->count();
			if($exists)
			{
				$query = $GLOBALS['con']->deleteFrom('content')->where('id', $id)->execute();
				$response = 200;
			}
			else
			{
				$response = 400;
			}
		}
		else
		{
			$response = 400;
		}
		return $response;
	}

	public function editContent($request)
	{
		$response = 400;

		if(!empty($request['id']))
		{
			$count = $GLOBALS['con']->from('content')->where('id',$request['id'])->count();

			if($count > 0)
			{
				$values = array('content' => $request['content']);
			$query = $GLOBALS['con']->update('content', $values, $request['id'])->execute();

				$response = 200;
			}
			else
			{
				$response = 400;
			}
		}
		return $response;
	}
		
}
