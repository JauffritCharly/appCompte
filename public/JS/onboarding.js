const btnSuivantQuestionnaire = document.querySelector('#questionSuivante');
const partie1 = document.querySelector('.questionPartie1');
const partie2 = document.querySelector('.questionPartie2');
const numeroEtape = document.querySelector('#numeroEtape');
const btnOuiRevenus = document.querySelector('.btn-reponse-oui-revenus');
const btnNonRevenus = document.querySelector('.btn-reponse-non-revenus');
const rubriqueAutreRevenus = document.querySelector('.autreRevenus');
const valeurInputSalaireBrut = document.querySelector('#questionnaire_form_salaire');
const phraseRemplir = document.querySelector('.phrase-remplir-champs');
const partie3 = document.querySelector(".autredepense");
const btnTerminer = document.querySelector(".btnTerminer")
const methodeEconomieContainer = document.querySelector(".methodeEconomieContainer");
const btnOuiAcquisition = document.querySelector(".btn-reponse-oui-acquisition");
const btnNonAcquisition = document.querySelector(".btn-reponse-non-acquisition");
const questionAcquisition = document.querySelector(".question-type-acquisition-container");
const typeAcquisition = document.querySelector(".typeAcquisitionContainer");

let n = 1;

// ----- Bouton Suivant Questionnaire : ------

btnSuivantQuestionnaire?.addEventListener('click', () => {
    if (valeurInputSalaireBrut.value >= 1 && n === 1) {
        rubriqueAutreRevenus.style.display = 'block';
        partie1.style.display = 'none';
        phraseRemplir.style.display = 'none'
        valeurInputSalaireBrut.classList.remove('active')
        n = n + 1;
        numeroEtape.innerText = n;

    } else if (n === 1) {
        valeurInputSalaireBrut.classList.add('active')
        phraseRemplir.style.display = 'block'

    } else if (n === 2) {
        partie3.style.display = 'block';
        partie2.style.display = 'none';
        rubriqueAutreRevenus.style.display = 'none';
        n = n + 1;
        numeroEtape.innerText = n;

    } else if (n === 3) {
        methodeEconomieContainer.style.display = 'block';
        partie3.style.display = 'none';
        btnTerminer.style.display = 'block';
        btnSuivantQuestionnaire.style.display = 'none';
        n = n + 1;
        numeroEtape.innerText = n;
    }

});

// ----  Bouton OUI ou NON rubrique autre revenus: ------

btnOuiRevenus?.addEventListener('click', () => {
    partie2.style.display = 'block';
    btnOuiRevenus.classList.add('btnReponse-clique');
    btnNonRevenus.classList.remove('btnReponse-clique');
});

btnNonRevenus?.addEventListener('click', () => {
    partie2.style.display = 'none';
    btnNonRevenus.classList.add('btnReponse-clique')
    btnOuiRevenus.classList.remove('btnReponse-clique');
});

// ----  Bouton OUI ou NON rubrique type d'acquisition: ------

btnOuiAcquisition?.addEventListener('click', () => {
    typeAcquisition.style.display = 'block';
    btnOuiAcquisition.classList.add('btnReponse-clique');
    btnNonAcquisition.classList.remove('btnReponse-clique');
});

btnNonAcquisition?.addEventListener('click', () => {
    typeAcquisition.style.display = 'none';
    btnNonAcquisition.classList.add('btnReponse-clique')
    btnOuiAcquisition.classList.remove('btnReponse-clique');
});


//  Modale autre revenus :

const modalContainer1 = document.querySelector(".container-modal1");
const modalTriggers1 = document.querySelectorAll(".modal-trigger1");

modalTriggers1.forEach(trigger => trigger.addEventListener("click", toggleModal1));

function toggleModal1() {
    modalContainer1.classList.toggle("active");
}

//  Modale dépense récurentes :

const modalContainer2 = document.querySelector(".container-modal2");
const modalTriggers2 = document.querySelectorAll(".modal-trigger2");

modalTriggers2.forEach(trigger => trigger.addEventListener("click", toggleModal2));

function toggleModal2() {
    modalContainer2.classList.toggle("active");
}


// ----------------------------  FORMULAIRE INSCRIPTION   ------------------------------


// Verification des données de l'email :

const validationIcone = document.querySelectorAll(".img-valide");
const errorIcone = document.querySelectorAll(".icone-error");

const mailInput = document.querySelector(".input-container:nth-child(1) input");
const regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/

mailInput.addEventListener("blur", mailValidation)
mailInput.addEventListener("input", mailValidation)


function mailValidation() {
    if (regexEmail.test(mailInput.value)) {
        validationIcone[0].style.display = 'inline';
        errorIcone[0].style.display = 'none';
    } else {
        validationIcone[0].style.display = 'none';
        errorIcone[0].style.display = 'inline';
    }
}

// Confirmation de l'email :

const mailConfirmationInput = document.querySelector(".input-container:nth-child(2) input");

mailConfirmationInput.addEventListener("blur", mailConfirmation)
mailConfirmationInput.addEventListener("input", mailConfirmation)

function mailConfirmation() {
    const confirmationMailValue = mailConfirmationInput.value;

    if (!confirmationMailValue && !mailInput.value) {
        validationIcone[1].style.display = 'none';
    } else if (confirmationMailValue !== mailInput.value) {
        errorIcone[1].style.display = 'inline';
        validationIcone[1].style.display = 'none';
    } else {
        errorIcone[1].style.display = 'none';
        validationIcone[1].style.display = 'inline';
    }
}

// Verification de la données saisie du mot de passe :

const passwordInput = document.querySelector(".input-container:nth-child(3) input");


const passwordVerification = {
    length: false,
    symbol: false,
    number: false
}

const regexList = {
    symbol: /[^a-zA-Z0-9\s]/,
    number: /[0-9]/
}

let passwordValue

passwordInput.addEventListener("blur", passwordValidation)
passwordInput.addEventListener("input", passwordValidation)

function passwordValidation(e) {
    passwordValue = passwordInput.value;
    let validationResult = 0;

    for (const prop in passwordVerification) {
        if (prop === "length") {
            if (passwordValue.length < 6) {
                passwordVerification.length = false;
            } else {
                passwordVerification.length = true;
                validationResult++;
            }
            continue;
        }

        if (regexList[prop].test(passwordValue)) {
            passwordVerification[prop] = true;
            validationResult++;
        } else {
            passwordVerification[prop] = false;
        }
    }

    if (validationResult !== 3) {
        errorIcone[2].style.display = 'inline';
        validationIcone[2].style.display = 'none';
    } else {
        errorIcone[2].style.display = 'none';
        validationIcone[2].style.display = 'inline';
    }

}

//   Confirmation du mot de passe :

const passwordConfirmationInput = document.querySelector(".input-container:nth-child(4) input");

passwordConfirmationInput.addEventListener("blur", passwordConfirmation)
passwordConfirmationInput.addEventListener("input", passwordConfirmation)

function passwordConfirmation() {

    const confirmationValue = passwordConfirmationInput.value;

    if (!confirmationValue && !passwordValue) {
        validationIcone[3].style.display = 'none';
    } else if (confirmationValue !== passwordValue) {
        errorIcone[3].style.display = 'inline';
        validationIcone[3].style.display = 'none';
    } else {
        errorIcone[3].style.display = 'none';
        validationIcone[3].style.display = 'inline';
    }
}

// ----- Bouton Suivant et Retour Inscription : ------

const btnSuivantInscription = document.querySelector('#btnSuivantInscription');
const btnRetour = document.querySelector('.btnRetour');
const contFormInscription = document.querySelector('.containerFormInscription')
const inscriptionPartie1 = document.querySelector('#inscriptionPartie1');
const inscriptionPartie2 = document.querySelector('#inscriptionPartie2');

btnSuivantInscription.addEventListener('click', suivant)

let animmee = false

function suivant(e) {

    if (!mailInput.value || !mailConfirmationInput.value || !passwordInput.value || !passwordConfirmationInput.value) {
        inscriptionPartie1.style.display = 'block';
        inscriptionPartie2.style.display = 'none';
        contFormInscription.classList.add("shake");
        animmee = true;
        setTimeout(() => {
            contFormInscription.classList.remove("shake")
            animmee = false;
        }, 400)
    } else {
        inscriptionPartie1.style.display = 'none';
        inscriptionPartie2.style.display = 'block';
    }
}


btnRetour.addEventListener('click', () => {
    inscriptionPartie1.style.display = 'block';
    inscriptionPartie2.style.display = 'none';
})

