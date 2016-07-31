# Konek: Simple PDO Wrap by stupid for stupid #

## Features ##

* Nothing much
* Just a simple PDO wrapper
* Easy to use

## Changelogs ##

###2.0.0.1###
- Sqlite support
- Removed limits on delete
- Organize Namespace
- DB::create(array $array) method added
- DB::find($id) method added
- DB::rm($id) method added
###2.0.0.0###
- init

## Prerequisite ##

* PHP >= 7
* PDO

## Usage ##

* You can start by creating a new instance of DB [$sample = new Yakovmeister\Konek\Database\DB("table_name")]
* Note that, second argument is optional if you're planning to use Mysql, which is the database by default
* Once you have created a new instance of DB you can do [$sample->get()] which is equivalent to ["select * from table_name"]
* You can also try [$sample->where("column", "=", "value")->get()] which is equivalent to ["select * from table_name where column = `value`"]
* you can actually chain multiple where statement [$sample->where("someone","like","you")->where("relationship_status","=","single")->get()] which is equivalent to ["select * from table_name where someone like `you` and where relationship_status = `single`"]
* you can also set limit by using the limit($count) method [$sample->where('attr', '=', 'handsome')->limit(4)->get()] which is equivalent to ["select * from table_name where attr = `handsome` LIMIT 4"]
* or you can set an offset, [$sample->where("attr", '=',"handsome")->skip(5)->get()] which is equivalent to ["select * from table_name where attr = `handsome` OFFSET 5"]


## FAQ ##

* Y u dis human? As I dig deeper into PHP, I tried to use what I've learned, so Konek was born.
* human, dis iz stpid, y stil do? Why not? I mean, how else could you practice what you've learned if you're not doing anything? eh?
* doz it support relationships? As far as I'm concern, this doesn't support relationship yet, it doesn't allow you to call data from related table, I mean it's unfair for me to create a PDO wrapper that could support relationship, yet here I am single and miserable. (lol) however you can use SINGLEton though. HAHAHA
* cn diz create/delete/edit table? No. But I might add it if I have some more free time, for now let's just settle with what's available.
* wuht doz it do? well basically, you can only use this to create, update, delete, and read your data from database. Most of the basic jobs.
* wuht about SQLite? I'm planning to suppport sqlite, but for now, have fun with Mysql. 