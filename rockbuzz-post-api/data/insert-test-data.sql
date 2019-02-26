insert into authors (name) values ('Jack Black');
insert into authors (name) values ('Kyle Gass');

insert into tags (name) values ('Rock & Roll');
insert into tags (name) values ('Acoustic');

insert into posts (author_id, title, slug, body, published) values ((select id from authors where name = 'Jack Black'), 'Tenacios D Biography', 'tenacios-d-biography', 'Rightfully hailed as "the greatest band on Earth," the super-sized acoustic metal/comedy duo Tenacious D was an unlikely success story. Actually, Tenacious D was probably so successful precisely because they were so unlikely: few people would imagine that two chunky guys bashing on acoustic guitars, singing songs like a tribute to the greatest song in the world (because they forgot how the greatest song in the world went after conquering the Devil with it), became one of the biggest cult bands of the late ''90s and 2000s. But the sheer charisma, humor, and energy -- not to mention inspired songwriting -- of singers/guitarists/actors Jack Black and Kyle Gass (aka JB, Jables, KG, and Kage, among other aliases) took them from L.A.''s underground comedy scene to their own series on HBO and a major-label album deal.<br/><br/>
The crazed, wide-ranging sense of humor and intensity that Black brought to Tenacious D also made him a sought-after character actor, appearing in films like Bob Roberts, The Cable Guy, and Saving Silverman; Gass'' film career includes supporting roles in Jacob''s Ladder, Idle Hands, and Evolution. Similarly, the D''s act showcased Black''s theatrical, versatile vocals and Gass'' deft support on the guitar in seemingly stream-of-consciousness songs about smoking pot, the duo''s musical and sexual prowess, and subjects straight out of Dungeons & Dragons, as well as in equally absurd and inventive sketches.<br/><br/>
The duo met at an acting class and began playing together in 1994, making their live debut later that year at Al''s Bar, playing just one number, the aforementioned homage to the world''s greatest song, "Tribute." In the audience that night was comedian/actor David Cross, who invited Black and Gass to appear with him and other like-minded performers such as Ben Stiller and Janeane Garofalo in a series of alternative comedy shows. The D soon headlined shows at venues like Pedro''s and Largo, planting the seeds of a die-hard cult following; not even their inauspicious film debut in 1996''s Bio-Dome slowed their momentum.<br/><br/>
The following year, their appearances on Bob Odenkirk and Cross'' brilliant HBO sketch comedy program Mr. Show with Bob and David and a 1998 performance of "Sex Supreme" -- which sang the praises of a ménage à trois with KG and JB -- on Saturday Night Live hinted at the duo''s just-beneath-the surface popularity, which began to rise into the mainstream with the group''s 1999 HBO series. Though it lasted just three episodes, Tenacious D included, among other adventures, the group''s search for "Inspirato," the cosmic creative force; the love triangle between Black, Gass, and a heavily pierced, Satanic clog dancer who threatened to destroy the group; and the discovery of Lee, Tenacious D''s biggest fan. More of the D''s brilliantly dumb songs debuted on the show, and fans began trading and auctioning video and audiotapes of Tenacious D.<br/><br/>
The duo also played opening gigs for friends like Beck, Pearl Jam, and the Foo Fighters and embarked on their first full-fledged tour; Epic won a bidding war to sign the group. In 2000, Black''s popularity and prominence as an actor grew with roles in films like Jesus'' Son and, especially, High Fidelity, where his turn as the larger-than-life record store clerk Barry made him a bona-fide star. Meanwhile, the group worked on a self-titled debut album with the Dust Brothers, Dave Grohl, Phish''s Page McConnell, Redd Kross'' Steve McDonald, and other friends.<br/><br/>
In 2001, the D''s momentum hit critical mass: the group set out on their second nationwide tour, playing significantly larger venues than before and selling out many of their dates. And, despite an attempt to recall Tenacious D at the last moment because of its back cover, which depicted two babies chained to an altar, their debut entered the charts at a surprisingly strong number 33. Meanwhile, Spumco, the production company of Ren & Stimpy mastermind John K., crafted an appropriately witty and raunchy video for the single "Fuck Her Gently," and, last but not least, the duo continued work on a Tenacious D movie, The Pick of Destiny, which was released in 2006 along with a soundtrack of new material from the dynamic duo. The band kept a fairly low profile after the release of the film, making appearances at festivals and benefits until finally making a return to music in 2012 with the release of their third album, Rize of the Fenix.<br/><br/>
Tenacious D spent the next five years working on new material, which slowly morphed from a fourth album to an online animated series. Entitled Post-Apocalypto, the series debuted in October of 2018, with its accompanying soundtrack appearing the following month. ~ Heather Phares, Rovi', 1);

insert into post_tag (post_id, tag_id) values (
  (select id from posts where slug = 'tenacios-d-biography'),
  (select id from tags where name = 'Rock & Roll')
);
insert into post_tag (post_id, tag_id) values (
  (select id from posts where slug = 'tenacios-d-biography'),
  (select id from tags where name = 'Acoustic')
);