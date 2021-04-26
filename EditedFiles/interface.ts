export interface Information {
    articles: Article[];
}

export interface Article {
    data: string;
    tema: string;
    informacio: string;
    vist: number;
}

export interface File {
    absercias: Absence[];
    observaciones: Observation[];
    incidencias: Incident[];
}

export interface Absence {
    data: string;
    h1: string;
    h2: string;
    h3: string;
    h4: string;
    h5: string;
    h6: string;
}

export interface Observation {
    data: string;
    profesor: string;
    tipificacion: string;
    detalle: string;
}

export interface Incident {
    data: string;
    profesor: string;
    tipificacion: string;
    detalle: string;
}

export class Profile {
    nomAlumne: string;
    grup: string;
    tutorGrup: string;
    tutor1: string;
    tutor2: string;
    municipi: string;
    codi_postal: string;
    direccio: string;
    usuaris: User[];
    imagen: string;
}

export class User {
    nomUsuari: string;
    usuari: string;
    email: string;
    tlf: string;
}

export interface Document {
    data: string;
    tema: string;
    msg: string;
    professor: string;
    venciment: string;
}
