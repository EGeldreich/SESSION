INSERT INTO `category` (`name`) VALUES
('Front-end'),
('Back-end'),
('Design'),
('Développement Web'),
('Bases de données'),
('Frameworks');

INSERT INTO `lesson` (`category_id`, `name`) VALUES
(1, 'Introduction CSS'),
(1, 'CSS Avancé'),
(1, 'Introduction JavaScript'),
(1, 'JavaScript Avancé'),
(2, 'Introduction PHP'),
(2, 'Node.js pour débutants'),
(2, 'API RESTful'),
(3, 'Introduction au Design UX'),
(3, 'Principes du Design Responsive'),
(4, 'Introduction au Développement Web'),
(5, 'SQL de base'),
(5, 'Optimisation des bases de données'),
(6, 'React pour débutants'),
(6, 'Introduction à Angular');


INSERT INTO `formation` (`name`) VALUES
('Développement Web'),
('Design UX'),
('Développement Front-end'),
('Développement Back-end'),
('Développement Full-Stack'),
('Bases de données');


INSERT INTO `teacher` (`name`, `firstname`, `email`) VALUES
('Dupont', 'Emmanuel', 'emmanuel.dupont@example.com'),
('Martin', 'Claire', 'claire.martin@example.com'),
('Lemoine', 'Julien', 'julien.lemoine@example.com'),
('Durand', 'Sophie', 'sophie.durand@example.com');


INSERT INTO `session` (`teacher_id`, `formation_id`, `name`, `place`, `date_start`, `date_end`) VALUES
(1, 1, 'Développement Web - Session 1', 10, '2025-03-01', '2025-03-05'),
(2, 2, 'Design UX - Session 1', 15, '2025-03-10', '2025-03-15'),
(3, 3, 'Développement Front-end - Session 1', 10, '2025-04-01', '2025-04-10'),
(4, 4, 'Développement Back-end - Session 1', 15, '2025-04-15', '2025-04-20');


INSERT INTO `program` (`session_id`, `lesson_id`, `duration`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 1),
(2, 8, 1),
(2, 9, 1),
(3, 4, 1),
(3, 5, 1),
(4, 6, 1),
(4, 7, 1);


INSERT INTO `student` (`name`, `firstname`, `date_birth`, `city`, `email`, `gender`, `phone`) VALUES
('Durand', 'Alice', '1995-05-10', 'Paris', 'alice.durand@example.com', 'F', '0123456789'),
('Lemoine', 'Paul', '1998-11-22', 'Lyon', 'paul.lemoine@example.com', 'M', '0987654321'),
('Dupont', 'Marie', '2000-02-18', 'Marseille', 'marie.dupont@example.com', 'F', '0147258369'),
('Martin', 'Louis', '1997-08-30', 'Bordeaux', 'louis.martin@example.com', 'M', '0764839201');


INSERT INTO `student_session` (`student_id`, `session_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);
