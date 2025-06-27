<?php
/*
File: Database User Creator
Author: David Sarkies
Initial: 2 June 2025
Update: 2 June 2025
Version: 4.0

Usage: Requires two arguments
python3 createUser.py [schema name] [user code] [json file name default db_new.json] [RW for readwrite else RO for read only]
*/



$failed = False;

if(count($argv)<2) {
	print("You must include the database name.\n");
	$failed = True;
}

if(count($argv)<3) {
	print("You must include a code for the user.\n");
	$failed = True;
}

$auth_name = "db_new.json";
if(count($argv)>2) {
	$auth_name = $argv[3];
}

$write = False;
if(count($argv)>3){
	if ($argv[4]=="RW"){
		$write = True;
	}
}

var_dump($argv);

/*
def add_user():


	#Hide environment variables from historyu

	pw_string_size = 80
	un_string_size = 20
	user_name_old = db_data['User']

	user_name = user_code + ''.join(secrets.choice("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789") for _ in range(un_string_size))
	password = ''.join(secrets.choice("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*") for _ in range(pw_string_size))

	if user_name_old and user_name_old.startswith(sys.argv[2]):
		cur.execute(f"DROP USER IF EXISTS `{user_name_old}`@`{hostname}`")

	cur.execute("CREATE USER {}@{} IDENTIFIED BY '{}'".format(user_name,hostname,password))

	if write:
		cur.execute("GRANT SELECT, INSERT, UPDATE, DELETE ON {}.* To '{}'@'{}'".format(database,user_name,hostname))
	else:
		cur.execute("GRANT SELECT ON {}.* To '{}'@'{}'".format(database,user_name,hostname))

	data ={'Name':hostname,
			'User':user_name,
			'Password':password,
			'DB':database,
			'MapsKey':mapsKey,
			'TimeStamp':str(datetime.now())}

	print(data)

	with open(auth_name+".json", 'w') as f:
		json.dump(data, f)

	
if not failed:

	user_code = sys.argv[2]+"RO"
	if write:
		user_code = sys.argv[2]+"RW"

	try:
		with open ("db_root.json") as data:
			db_data = json.load(data)
	except:
		print("Error loading json data")

	hostname = 'localhost'
	username = db_data['User']
	password = db_data['Password']
	mapsKey = "key=AIzaSyDozekXvwV92zdmGibnoBijugU4PJhY9c0"
	database = sys.argv[1]

	print("Connecting")
	#The main function. The database is opened, and the functions are executed
	myConnection = pymysql.connect(host=hostname, user = username, passwd = password, db = database, charset='utf8')
	cur = myConnection.cursor()
	print("Connected")

	cur.execute('SET NAMES utf8')
	cur.execute('SET CHARACTER SET utf8')
	cur.execute('SET character_set_connection=utf8')
	cur.execute("SET FOREIGN_KEY_CHECKS = 0")
	add_user()
*/


/*
27 June 2025 - Created file
*/
?>