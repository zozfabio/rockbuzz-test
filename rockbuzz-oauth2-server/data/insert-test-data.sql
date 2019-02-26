insert into user(email, name, password) values ('user@test.com', 'Some User', '$2y$10$PYchRZ9u3gDYass8BUYwWOtVGuItMhSZBwxMQp7yuMj1TBltKi.2y');

insert into scope(name) values ('authors.findAll');
insert into scope(name) values ('tags.findAll');
insert into scope(name) values ('posts.findAll');
insert into scope(name) values ('posts.findOneBySlug');
insert into scope(name) values ('posts.author');
insert into scope(name) values ('posts.tags');

insert into client(name, secret, redirect_uri, confidential) values ('rockbuzz-blog', '$2y$10$Zr4arAI1a/aLm/LXSy8sguIHzu.YvRJ834Z6eC9KyU9vCzv/JTmwW', 'http://localhost:8002', true);
insert into client_scopes(client_id, scope_id) values ((select id from client where name = 'rockbuzz-blog'), (select id from scope where name = 'authors.findAll'));
insert into client_scopes(client_id, scope_id) values ((select id from client where name = 'rockbuzz-blog'), (select id from scope where name = 'tags.findAll'));
insert into client_scopes(client_id, scope_id) values ((select id from client where name = 'rockbuzz-blog'), (select id from scope where name = 'posts.findAll'));
insert into client_scopes(client_id, scope_id) values ((select id from client where name = 'rockbuzz-blog'), (select id from scope where name = 'posts.findOneBySlug'));
insert into client_scopes(client_id, scope_id) values ((select id from client where name = 'rockbuzz-blog'), (select id from scope where name = 'posts.author'));
insert into client_scopes(client_id, scope_id) values ((select id from client where name = 'rockbuzz-blog'), (select id from scope where name = 'posts.tags'));

insert into client(name, secret, redirect_uri, confidential) values ('rockbuzz-admin', '$2y$10$KTgvCHbbaO.SappB..bike5hsF1Aed5mCYVZfz1RRCrUIsPi5XSj.', 'http://localhost:8003', true);
insert into client_scopes(client_id, scope_id) values ((select id from client where name = 'rockbuzz-admin'), (select id from scope where name = 'authors.findAll'));
insert into client_scopes(client_id, scope_id) values ((select id from client where name = 'rockbuzz-admin'), (select id from scope where name = 'tags.findAll'));
insert into client_scopes(client_id, scope_id) values ((select id from client where name = 'rockbuzz-admin'), (select id from scope where name = 'posts.findAll'));