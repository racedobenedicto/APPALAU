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

  getMsg( subject: string, global: GlobalVar, tipus: string ) {
    return this.runQuery<Msg[]>(`methode=readMSG&idUser=${ global.idUser }&token=${ global.token }&assignatura=${ subject }&tipus=${ tipus }`);
  }

  getChatHome( global: GlobalVar ) {
    return this.runQuery<string[][]>(`methode=chats&idUser=${ global.idUser }&token=${ global.token }`);
  }

  getProfile( global: GlobalVar ) {
    return this.runQuery(`methode=perfil&idUser=${ global.idUser }&token=${ global.token }`);
  }

  getInfo( global: GlobalVar ) {
    return this.runQuery<Information>(`methode=info&idUser=${ global.idUser }&token=${ global.token }`);
  }

  getDocs( global: GlobalVar ) {
    return this.runQuery<Document[]>(`methode=documentation&idUser=${ global.idUser }&token=${ global.token }`);
  }

  getFile( global: GlobalVar ) {
    return this.runQuery<string>(`methode=expedient&idUser=${ global.idUser }&token=${ global.token }`);
  }

  getUser( global: GlobalVar ) {
    return this.runQuery<User>(`methode=users&idUser=${ global.idUser }&token=${ global.token }`);
  }

  updateUser( data: string[], global: GlobalVar ) {
    return this.runQuery(`methode=updateUser&idUser=${ global.idUser }&token=${ global.token }&direccio=${ data[0] }&municipi=${ data[1] }&codi_postal=${ data[2] }&user=${ data[3] }&telf=${ data[4] }&email=${ data[5] }`);
  }

  justify( data: string[], global: GlobalVar ) {
    return this.runQuery(`methode=justify&idUser=${ global.idUser }&token=${ global.token }&text=${ data[0] }&dia=${ data[1] }`);
  }

  sendMsg( subject: string, msg:string, global: GlobalVar ) {
    return this.runQuery(`methode=sendMSG&idUser=${ global.idUser }&token=${ global.token }&assignatura=${ subject }&msg=${ msg }`);
  }

  login( user: string, password: string, oneSignal: string ) {
    return this.runQuery(`methode=login&user=${ user }&password=${ password }&oneSignal=${oneSignal}`);
  }

}

