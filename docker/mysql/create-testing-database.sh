#!/usr/bin/env bash

mysql --user=root --password= <<-EOSQL
    CREATE DATABASE IF NOT EXISTS food_db;
    CREATE DATABASE IF NOT EXISTS testing;
    USE food_db;
EOSQL
