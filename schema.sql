-- Schema for Links Base (PostgreSQL / SQLite Compatible)

-- Links Table
CREATE TABLE IF NOT EXISTS links (
    id SERIAL PRIMARY KEY, -- In SQLite: INTEGER PRIMARY KEY AUTOINCREMENT
    title VARCHAR(255) NOT NULL,
    url TEXT NOT NULL,
    major_tag VARCHAR(100) NOT NULL,
    minor_tag VARCHAR(100) NOT NULL,
    description TEXT DEFAULT '',
    icon_url TEXT DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tag Metadata Table (Icons, Colors, Descriptions for Major & Minor tags)
CREATE TABLE IF NOT EXISTS tag_meta (
    id SERIAL PRIMARY KEY,
    major_tag VARCHAR(100) NOT NULL,
    minor_tag VARCHAR(100) DEFAULT '',
    icon VARCHAR(100) DEFAULT '',
    color VARCHAR(50) DEFAULT '',
    description TEXT DEFAULT '',
    UNIQUE(major_tag, minor_tag)
);
