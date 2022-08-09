	

	recaptcha_secret_key 6LdTNzQUAAAAACobDbHJW8PZjooVVMQNG_ibg8K6`
	recaptcha_site_key 6LdTNzQUAAAAAJZY_AaGVxxL8pHNeai-2N-SNmSj

	comercial@energiareal.es

	SELECT * FROM energys_cloud.tbloptions where name = 'recaptcha_secret_key' or name = 'recaptcha_site_key';

	update tbloptions set value='', autoload=0 where name = 'recaptcha_site_key';

