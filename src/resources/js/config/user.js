export const userTemplate = {
    id: null,
    name: null,
    steamId: null,
    twitterId: null,
    avatorImage: null,
    email: null,
    player: {
        id: null,
        name: null,
        mu: null,
        sigma: null,
        minRate: null,
        maxRate: null,
        win: null,
        defeat: null,
        draw: null,
        games: null,
        wp: null,
        gamePackages: null,
        joinedAt: null,
        lastGameAt: null,
        enabled: null
    },
    role: {
        id: null,
        name: null,
        level: null
    }
};

export const userStatus = {
    waiting: 1,
    active: 2,
    withdrawal: 3,
    banned: 4
};

export const userStatusLabels = [
    { id: userStatus.waiting, label: "承認待ち" },
    { id: userStatus.active, label: "有効" },
    { id: userStatus.withdrawal, label: "退会" },
    { id: userStatus.banned, label: "利用停止" }
];
