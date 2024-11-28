db.enderecos.insertMany([
  {
    _id: ObjectId("650000000000000000000001"),
    estado: "ES",
    cidade: "Vitória",
    bairro: "Jardim da Penha",
    rua: "Rua Tupinambás",
    numero: 342,
    complemento: "Sala 404",
  },
  {
    _id: ObjectId("650000000000000000000002"),
    estado: "ES",
    cidade: "Vitória",
    bairro: "Monte Belo",
    rua: "Rua Anselmo Serrate",
    numero: 199,
    complemento: null,
  },
  {
    _id: ObjectId("650000000000000000000003"),
    estado: "ES",
    cidade: "Vitória",
    bairro: "Enseada do Suá",
    rua: "Av. Nossa Sra. dos Navegantes",
    numero: 955,
    complemento: null,
  },
]);

db.barbearias.insertMany([
  {
    _id: ObjectId("650000000000000000000004"),
    nome: "Barbearia A",
    telefone: "(27) 99513-5998",
    endereco_id: ObjectId("650000000000000000000001"),
  },
  {
    _id: ObjectId("650000000000000000000005"),
    nome: "Barbearia B",
    telefone: "(27) 90909-7142",
    endereco_id: ObjectId("650000000000000000000002"),
  },
  {
    _id: ObjectId("650000000000000000000006"),
    nome: "Barbearia C",
    telefone: "(27) 99310-9941",
    endereco_id: ObjectId("650000000000000000000003"),
  },
]);

db.barbeiros.insertMany([
  {
    _id: ObjectId("650000000000000000000007"),
    nome: "admin",
    senha: "$2y$10$OXZA3S5qMCak3pKwwHVD2OL0oOFT2PQ4VOqOZ/QYf29eI5YvAtPJa",
    barbearia_id: ObjectId("650000000000000000000004"),
    foto: "imgs/default_image_barbeiro.png",
    admin: true,
  },
]);

db.tipos_cortes.insertMany([
  {
    _id: ObjectId("650000000000000000000008"),
    nome: "Pézinho",
  },
  {
    _id: ObjectId("650000000000000000000009"),
    nome: "Sobrancelha",
  },
  {
    _id: ObjectId("65000000000000000000000A"),
    nome: "Corte com Máquina",
  },
  {
    _id: ObjectId("65000000000000000000000B"),
    nome: "Disfarçado",
  },
  {
    _id: ObjectId("65000000000000000000000C"),
    nome: "Barba",
  },
  {
    _id: ObjectId("65000000000000000000000D"),
    nome: "Bigode",
  },
  {
    _id: ObjectId("65000000000000000000000E"),
    nome: "Pintar",
  },
  {
    _id: ObjectId("65000000000000000000000F"),
    nome: "Completo (Barba, Cabelo e Bigode)",
  },
]);

db.cortes.insertMany([
  {
    _id: ObjectId("650000000000000000000010"),
    data_corte: ISODate("2024-11-26T00:00:00Z"),
    nome_cliente: "Cliente Exemplo",
    telefone_cliente: "(27) 99999-9999",
    barbeiro_id: ObjectId("650000000000000000000007"),
    cliente: "Sim",
    tipo_corte_id: ObjectId("650000000000000000000008"),
    horario: ISODate("2024-11-26T14:30:00Z"),
  },
]);

db.horarios.insertMany([
  {
    _id: ObjectId("650000000000000000000011"),
    horario: "09:00",
  },
  {
    _id: ObjectId("650000000000000000000012"),
    horario: "09:30",
  },
  {
    _id: ObjectId("650000000000000000000013"),
    horario: "10:00",
  },
  {
    _id: ObjectId("650000000000000000000014"),
    horario: "10:30",
  },
  {
    _id: ObjectId("650000000000000000000015"),
    horario: "11:00",
  },
  {
    _id: ObjectId("650000000000000000000016"),
    horario: "11:30",
  },
  {
    _id: ObjectId("650000000000000000000017"),
    horario: "12:00",
  },
  {
    _id: ObjectId("650000000000000000000018"),
    horario: "12:30",
  },
  {
    _id: ObjectId("650000000000000000000019"),
    horario: "13:00",
  },
  {
    _id: ObjectId("65000000000000000000001A"),
    horario: "13:30",
  },
  {
    _id: ObjectId("65000000000000000000001B"),
    horario: "14:00",
  },
  {
    _id: ObjectId("65000000000000000000001C"),
    horario: "14:30",
  },
  {
    _id: ObjectId("65000000000000000000001D"),
    horario: "15:00",
  },
  {
    _id: ObjectId("65000000000000000000001E"),
    horario: "15:30",
  },
  {
    _id: ObjectId("65000000000000000000001F"),
    horario: "16:00",
  },
  {
    _id: ObjectId("650000000000000000000020"),
    horario: "16:30",
  },
  {
    _id: ObjectId("650000000000000000000021"),
    horario: "17:00",
  },
  {
    _id: ObjectId("650000000000000000000022"),
    horario: "17:30",
  },
  {
    _id: ObjectId("650000000000000000000023"),
    horario: "18:00",
  },
  {
    _id: ObjectId("650000000000000000000024"),
    horario: "18:30",
  },
  {
    _id: ObjectId("650000000000000000000025"),
    horario: "19:00",
  },
]);
