INSERT INTO Dude (name, password) VALUES ('Ossi', 'Ossi123');
INSERT INTO Dude (name, password) VALUES ('Test', 'Test123');
INSERT INTO Type (name, dude) VALUES ('Koulujutut',1);
INSERT INTO Type (name, dude) VALUES ('Harrastukset',1);
INSERT INTO Type (name, dude) VALUES ('Työasiat',2);
INSERT INTO Type (name, dude) VALUES ('Hallitusasiat',2);
INSERT INTO Priority (name, prio, dude) VALUES ('Tee jo','10','1');
INSERT INTO Priority (name, prio, dude) VALUES ('Ei kiirettä','0','1');
INSERT INTO Priority (name, prio, dude) VALUES ('Kiirehdi','8','2');
INSERT INTO Priority (name, prio, dude) VALUES ('Semisti kiirettä','2','2');
INSERT INTO Note (name, description, dude, priority, added) VALUES ('tsoha', 'olispa jo valmis', '1', '1', NOW());
INSERT INTO Note (name, description, dude, priority, added) VALUES ('tutkinto', 'joskus vielä', '1', '2',  NOW());
INSERT INTO Note (name, description, dude, priority, added) VALUES ('työkriisi', 'kriisiä pukkaa', '2', '3',  NOW());
INSERT INTO Note (name, description, dude, priority, added) VALUES ('sopu', 'ehkä joskus sitten', '2', '4',  NOW());
INSERT INTO Typeonote (note, type) VALUES ('1','1');
INSERT INTO Typeonote (note, type) VALUES ('2','2');
INSERT INTO Typeonote (note, type) VALUES ('2','1');
INSERT INTO Typeonote (note, type) VALUES ('3','3');
INSERT INTO Typeonote (note, type) VALUES ('4','4');