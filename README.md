Gringo <https://jdrich@github.com/jdrich/gringo.git>

## About

Gringo is a disparaging name for a semi-useful little data storage library.
Useful if you don't need to delete anything, don't need queries, and don't plan
on scaling.

## Uses

Create an empty store, or access an existing store

    $store = new Gringo\Store('my_store', $path_to_store_directory);

Access the default object for that store (defined by default.json in the store directory)

    $record = $store->getDefault();

Assign values

    $record['value'] = 'potato';

Save

    $store->save($record);

Iterate through a store

    $store = new Gringo\Store('my_store', $path_to_store_directory);

    while($store->hasNext()) {
        $record = $store->next();

        // stuff
    }

Or backwards

    $store = new Gringo\Store('my_store', $path_to_store_directory);

    $record = $store->last();

    do {
        // stuff
    } while($record = $store->prev());

## Purpose

Gringo allows you to develop an application without a database with some minor
level of database functionality. Not really useful for much else.

## Author

Jonathan Rich <jdrich@gmail.com>

## Feedback

Submit bugs to https://github.com/jdrich/gringo/issues.

## License

Please see the file called LICENSE.
