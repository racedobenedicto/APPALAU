import { Injectable } from "@angular/core";

@Injectable()
export class GlobalVar {
    public idUser = "";
    public perfil = "";
    public token = "";
    public idOneSignal="";

    public setIdUser(idUser : string){
        this.idUser=idUser;
    }

    public setPerfil(perfil : string){
        this.perfil=perfil;
    }

    public setToken(token : string){
        this.token=token;
    }

    public setIdOnesignal(id : string){
        this.idOneSignal=id;
    }
}
 