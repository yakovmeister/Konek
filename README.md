Konek

a simple yet working eloquent based PDO wrapper.



Prerequisite

- PHP >= 7
- PDO
  

Features

- Easy to use
- configurable configuration file
  

Changelogs

2.1

- removed mysql and sqlite connection class
- added configuration file support
- removed unnecessary classes
- added root_path() function for detecting konek's root path

1.0 - 2.0 (source removed due to stupidity of the codes)

- Sqlite support
- Removed limits on delete
- Organize Namespace
- DB::create(array $array) method added
- DB::find($id) method added
- DB::rm($id) method added

- init

Usage

by creating instance

you can start by creating a DB instance

    <?php
      
      use Yakovmeister\Konek\Database\DB;
    
      $wrapper = new DB;
      // this is equivalent to `SELECT * FROM users`
      $wrapper->table('users')->all();
      // this is equivalent to `SELECT * FROM users where username = 'superadmin'`
      $wrapper->table('users')->where('username','=','superadmin')->get();
      
      // this is equivalent to `INSERT INTO users (username, password) VALUES('admin','vh3Ry53cUr3p45$w0rd')`
      $wrapper->table('users')->create([
         'username' => 'admin',
         'password' => bcrypt('vh3Ry53cUr3p45$w0rd') // assuming you're using bcrypt
      ]);
    

for shorter version, you can also do the following to omit using table()

    <?php
      
      use Yakovmeister\Konek\Database\DB;
    
      $wrapper = new DB("users"); //alternatively you can supply the table name as argument
      // then you can do...
      $wrapper->all();
      // or 
      $wrapper->where('username','=','superadmin')->get();



FAQ

- Y u dis human? As I dig deeper into PHP, I tried to use what I've learned, so Konek was born.
- human, dis iz stpid, y stil do? Why not? I mean, how else could you practice what you've learned if you're not doing anything? eh?
- doz it support relationships? As far as I'm concern, this doesn't support relationship yet, it doesn't allow you to call data from related table, I mean it's unfair for me to create a PDO wrapper that could support relationship, yet here I am single and miserable. (lol) however you can use SINGLEton though. HAHAHA
- cn diz create/delete/edit table? No. But I might add it if I have some more free time, for now let's just settle with what's available.
- wuht doz it do? well basically, you can only use this to create, update, delete, and read your data from database. Most of the basic jobs.
- wuht about SQLite? I'm planning to suppport sqlite, but for now, have fun with Mysql. 
