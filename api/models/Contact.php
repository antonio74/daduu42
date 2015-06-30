<?php
namespace api\models;


class Contact extends \common\models\Contact 
{	
/*	metodo spostato in \common\models\Contact

    // Quando è impostato il parametro GET expand=categoria elimina il campo superfluo id_categoria
	public function fields()
	{
		$fields = parent::fields();
		if(isset($_GET['expand'])){
			$param=explode(',', $_GET['expand']);
			foreach ($param as $key => $field)
				if(trim($field) == 'contact_category')
					unset($fields['contact_category_id']);
		}	
		//$fields['contact_category_id']=1;
		return $fields;
	}
*/

	/**
	 * Esempio:  http://host/contacts?expand=contact_category, contact_groups
	 * @return I campi da aggiungere al contatto utilizzando le relazioni del 
	 *		   Model Contact getContact_category, getContact_groups
	 */
    public function extraFields()
    {
        return ['contact_category', 'contact_groups'];
    }

}