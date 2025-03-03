#!/bin/bash

# Define the SQL file path
SQL_FILE="/docker-entrypoint-initdb.d/init.sql"

# Generate the SQL file dynamically using environment variables
cat <<EOF > $SQL_FILE
-- Drop user if exists
DROP USER IF EXISTS '${DB_USERNAME}'@'%';

-- Create new user with environment variables
CREATE USER '${DB_USERNAME}'@'%' IDENTIFIED WITH mysql_native_password BY '${DB_PASSWORD}';
ALTER USER '${DB_USERNAME}'@'%' IDENTIFIED WITH mysql_native_password BY '${DB_PASSWORD}';

-- Grant privileges
GRANT ALL PRIVILEGES ON *.* TO '${DB_USERNAME}'@'%';
FLUSH PRIVILEGES;
EOF

# Execute the generated SQL script
exec /usr/local/bin/docker-entrypoint.sh "$@"
