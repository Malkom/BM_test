# Gestion de base spatiale

L'application permets de géré le personnels et les vaiseaux asignée à la station

Spécification des données :

### Ship


| champ        | type   |
| ------------ | ------ |
| matricule    | string |
| modele       | string |
| crews        | Crew[] |
| subordinates | Ship[] |


### Crew


| champ      | type   |
| ---------- | ------ |
| matricule  | string |
| nom        | string |
| function   | string |
