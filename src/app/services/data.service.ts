import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { environment } from '../../environments/environment.prod';
import { Information, User, Msg } from '../interfaces/interface';
import { GlobalVar } from './GlobalVar';

const url = environment.url;

@Injectable({
  providedIn: 'root'
})
export class DataService {

  constructor( private http: HttpClient ) { }

  private runQuery<T>( query: string ) {
    query = url + query;
    return this.http.get<T>( query );
  }

  getMsg( subject: string, global: GlobalVar ) {
    return this.runQuery<Msg[]>(`/chats_msj.php?idUser=${ global.idUser }&token=${ global.token }&assignatura=${ subject }`);
  }

  getChatHome( global: GlobalVar ) {
    return this.runQuery<string[][]>(`/chats.php?idUser=${ global.idUser }&token=${ global.token }`);
  }

  getProfile( global: GlobalVar ) {
    return this.runQuery(`/perfil.php?idUser=${ global.idUser }&token=${ global.token }`);
  }

  getInfo( global: GlobalVar ) {
    return this.runQuery<Information>(`/info.php?idUser=${ global.idUser }&token=${ global.token }`);
  }

  getDocs( global: GlobalVar ) {
    return this.runQuery<Document[]>(`/documentation.php?idUser=${ global.idUser }&token=${ global.token }`);
  }

  getFile( global: GlobalVar ) {
    return this.runQuery<string>(`/expedient.php?idUser=${ global.idUser }&token=${ global.token }`);
  }

  getUser( global: GlobalVar ) {
    return this.runQuery<User>(`/users.php?idUser=${ global.idUser }&token=${ global.token }`);
  }

  updateUser( data: string[], global: GlobalVar ) {
    return this.runQuery(`/actualitzarUsuari.php?idUser=${ global.idUser }&direccio=${ data[0] }&municipi=${ data[1] }&codi_postal=${ data[2] }&usuari=${ data[3] }&tlf=${ data[4] }&email=${ data[5] }&token=${ global.token }`);
  }

  justify( data: string[], global: GlobalVar ) {
    return this.runQuery(`/justificar.php?idUser=${ global.idUser }&token=${ global.token }&text=${ data[0] }&dia=${ data[1] }`);
  }

  sendMsg( subject: string, msg:string, global: GlobalVar ) {
    console.log(`/chats_enviar.php?idUser=${ global.idUser }&assignatura=${ subject }&msg=${ msg }&token=${ global.token }`);
    return this.runQuery(`/chats_enviar.php?idUser=${ global.idUser }&assignatura=${ subject }&msg=${ msg }&token=${ global.token }`);
  }

  login( user: string, password: string, oneSignal: string ) {
    return this.runQuery(`/login.php?user=${ user }&password=${ password }&oneSignal=${oneSignal}`);
  }

}

