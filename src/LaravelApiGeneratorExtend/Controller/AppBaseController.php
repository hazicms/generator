<?php namespace HaziCms\Generator\Controller;

use HaziCms\Http\Controllers\Controller;
use Mitul\Generator\Exceptions\AppValidationException;

class AppBaseController extends Controller
{
	public function validateRequest($request, $rules)
	{
		$validator = $this->getValidationFactory()->make($request->all(), $rules);

		if($validator->fails())
			throw new AppValidationException("Validation failed", ERROR_CODE_VALIDATION_FAILED, $validator->errors()->getMessages());
	}
}