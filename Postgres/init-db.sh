#!/bin/bash
set -e

# List of apps and their databases
databases=(nextcloud owncloud piwigo pydio seafile filerun zenphoto coppermine mailcow hmailserver)

for db in "${databases[@]}"; do
    echo "Initializing database: $db"
    psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
        CREATE DATABASE $db;
        GRANT ALL PRIVILEGES ON DATABASE $db TO "$POSTGRES_USER";
EOSQL
    psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$db" <<-EOSQL
        GRANT ALL ON SCHEMA public TO "$POSTGRES_USER";
        ALTER SCHEMA public OWNER TO "$POSTGRES_USER";
EOSQL
done
