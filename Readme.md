# Gestion de base spatiale

L'application permet de gérer le personnel et les vaisseaux assignés à la station

Spécification des données :

### Ship


| champ        | type   |
| ------------ | ------ |
| matricule    | string |
| modele       | string |
| crews        | Crew[] |
| subordinates | Ship[] |


### Crew


| champ     | type   |
| --------- | ------ |
| matricule | string |
| nom       | string |
| job       | string |
