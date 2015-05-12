<?php 
class PortfolioRepo{

	public function getPortfolio($request)
	{
			$requestData = $request;
			// Initial response is bad request
			$response = 400;

			// If there is some data in json form
			if(!empty($requestData['id']))
			{				
				$count = $GLOBALS['con']->from('portfolio')->where('id',$request['id'])->count();
				if($count > 0)
				{
					$exists = $GLOBALS['con']->from('portfolio')->where('id',$requestData['id']);
					$data = array();

					foreach($exists as $portfolio)
			    	{
			    		$portfolio['web_url'] = UtilityRepo::getRootPath(false).'data/portfolio/'.$portfolio['image'];			    		
						$data[] = $portfolio;

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
				if(isset($request['status']))
				{
					$exists = $GLOBALS['con']->from('portfolio')->where('`status`' , $request['status']);
				}
				else
					$exists = $GLOBALS['con']->from('portfolio');
					$data = array();

				foreach($exists as $portfolio)
		    	{
		    		$portfolio['web_url'] = UtilityRepo::getRootPath(false).'data/portfolio/'.$portfolio['image'];
					$data[] = $portfolio;

				}

				$response = 200;
					
			}
			
			return array('code' => $response,'data' => $data);
			
	}

	public function deletePortfolio($request)
	{
		$id = $request['id'];
		$response = 400;

		if(!empty($id))
		{
			$exists = $GLOBALS['con']->from('portfolio')->where('id',$id)->count();
			if($exists)
			{
				$query = $GLOBALS['con']->deleteFrom('portfolio')->where('id', $id)->execute();
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

	public function addPortfolio($request)
	{
		$response = 400;
		if(!empty($request))
		{
			$values = array('name' => $request['name'],'image' => $request['image'], '`desc`' => $request['desc'], '`status`' => $request['status']);
			$query = $GLOBALS['con']->insertInto('portfolio', $values)->execute();


			$response = '200';
		}
		else
		{
			$response = '400';
		}


		return $response;

	}

	public function editPortfolio($request)
	{
		$response = 400;

		if(!empty($request['id']))
		{
			$count = $GLOBALS['con']->from('portfolio')->where('id',$request['id'])->count();

			if($count > 0)
			{
				$values = array('name' => $request['name'], 'image' => $request['image'], '`desc`' => $request['desc'], '`status`' => $request['status']);
			$query = $GLOBALS['con']->update('portfolio', $values, $request['id'])->execute();

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